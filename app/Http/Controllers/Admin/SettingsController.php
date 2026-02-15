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
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($validated['settings'] as $key => $value) {
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

        // Log the action
        AuditLog::log(
            'settings.updated',
            'System settings were updated',
            null,
            ['settings_count' => count($validated['settings'])]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
