<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Settings Update Request:', $request->all());
        \Illuminate\Support\Facades\Log::info('Files:', $request->allFiles());

        $validated = $request->validate([
            'settings' => 'array',
            'settings.*' => 'nullable', // Allow all keys in settings array to pass validation
            'settings.system_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle File Upload
        $logoFile = $request->file('settings.system_logo');
        
        // Fallback for nested array if dot notation fails
        if (!$logoFile && $request->hasFile('settings')) {
            $files = $request->file('settings');
            if (isset($files['system_logo'])) {
                $logoFile = $files['system_logo'];
            }
        }

        if ($logoFile) {
            $path = $logoFile->store('settings', 'public');
            Setting::set('system_logo', '/storage/' . $path, 'string', 'general');
        }

        if (isset($validated['settings'])) {
            foreach ($validated['settings'] as $key => $value) {
                // Skip the file input as it's handled separately
                if ($key === 'system_logo') continue;

                // Determine type based on value
                $type = 'string';
                if (is_bool($value) || $value === 'true' || $value === 'false') {
                    $type = 'boolean';
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } elseif (is_numeric($value)) {
                    $type = 'integer';
                }

                // Determine group from key prefix
                $group = 'general';
                if (str_starts_with($key, 'exam_')) {
                    $group = 'exam';
                } elseif (str_starts_with($key, 'email_')) {
                    $group = 'email';
                } elseif (str_starts_with($key, 'security_')) {
                    $group = 'security';
                }

                Setting::set($key, $value, $type, $group);
            }
        }
        
        // Log the action
        AuditLog::log(
            'settings.updated',
            'System settings were updated',
            null,
            ['settings_count' => count($validated['settings'] ?? [])]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
