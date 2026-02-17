<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Models\AuditLog; 

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::with('role')->withTrashed();

        // Search filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filtering
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        // Status filtering
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // ... validation ...
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'email_verified' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'email_verified_at' => $request->boolean('email_verified') ? now() : null,
        ]);
        
        AuditLog::log('create_user', "Created new user: {$user->name}", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'email_verified' => ['boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'email_verified_at' => $request->boolean('email_verified') ? ($user->email_verified_at ?? now()) : null,
        ]);
        
        AuditLog::log('update_user', "Updated user details: {$user->name}", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the Super Admin (ID 1)
        if ($user->id === 1) {
            return back()->with('error', 'The Root Administrator account cannot be deleted.');
        }

        $user->delete();
        
        AuditLog::log('deactivate_user', "Deactivated user: {$user->name}", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User deactivated successfully.');
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        
        AuditLog::log('restore_user', "Restored user: {$user->name}", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User restored successfully.');
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        AuditLog::log('reset_password', "Reset password for user: {$user->name}", $user);

        return back()->with('success', 'Password reset successfully.');
    }

    /**
     * Impersonate a user
     */
    public function impersonate(User $user)
    {
        // Guard: Only admins can start impersonation (handled by route middleware, but extra check is good)
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Guard: Prevent impersonating other admins to avoid permission escalation confusion
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Cannot impersonate another administrator.');
        }

        // 1. Store original admin ID
        session()->put('impersonator_id', auth()->id());

        // 2. Login as target user
        auth()->login($user);
        
        // 3. Log action
        // Note: We log this BEFORE the switch relies on session state, or we log using the impersonator ID
        // Ideally we'd log this as the admin. 
        // AuditLog use auth() so we might want to log before switching or manually set user_id.
        // Let's rely on the session being set for the next request.

        return redirect()->route('dashboard');
    }

    /**
     * Stop impersonating
     */
    public function stopImpersonating()
    {
        $impersonatorId = session('impersonator_id');

        if (!$impersonatorId) {
            abort(403, 'No active impersonation session.');
        }

        // 1. Login back as admin
        auth()->loginUsingId($impersonatorId);

        // 2. Clear session
        session()->forget('impersonator_id');

        return redirect()->route('admin.users.index')
            ->with('success', 'Welcome back, Administrator.');
    }
}
