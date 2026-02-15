<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Display list of backups
     */
    public function index()
    {
        $backups = $this->getBackupList();
        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Create a new database backup
     */
    public function create()
    {
        try {
            // Ensure backups directory exists
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }

            $filename = 'backup_' . date('Y-m-d_His') . '.sql';
            $filepath = storage_path('app/backups/' . $filename);

            // Get database config
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s %s %s > "%s" 2>&1',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                $password ? '--password=' . escapeshellarg($password) : '',
                escapeshellarg($database),
                $filepath
            );

            // Execute mysqldump
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0 || !file_exists($filepath) || filesize($filepath) === 0) {
                // If mysqldump failed, try PHP-based backup
                $this->phpBackup($filepath, $database);
            }

            if (file_exists($filepath) && filesize($filepath) > 0) {
                AuditLog::log(
                    'backup.created',
                    'Database backup created: ' . $filename,
                    null,
                    ['filename' => $filename, 'size' => filesize($filepath)]
                );

                return back()->with('success', 'Database backup created successfully: ' . $filename);
            }

            return back()->with('error', 'Failed to create database backup. Please check server configuration.');

        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * PHP-based backup fallback when mysqldump is unavailable
     */
    protected function phpBackup(string $filepath, string $database)
    {
        $tables = \DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $database;

        $sql = "-- SISC Entrance Exam System Database Backup\n";
        $sql .= "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: {$database}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // Get CREATE TABLE statement
            $createTable = \DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $rows = \DB::select("SELECT * FROM `{$tableName}`");
            if (count($rows) > 0) {
                $columns = array_keys((array) $rows[0]);
                $columnList = '`' . implode('`, `', $columns) . '`';

                foreach (array_chunk($rows, 100) as $chunk) {
                    $values = [];
                    foreach ($chunk as $row) {
                        $rowValues = array_map(function ($val) {
                            if (is_null($val)) return 'NULL';
                            return "'" . addslashes($val) . "'";
                        }, array_values((array) $row));
                        $values[] = '(' . implode(', ', $rowValues) . ')';
                    }
                    $sql .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES\n" . implode(",\n", $values) . ";\n\n";
                }
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($filepath, $sql);
    }

    /**
     * Download a backup file
     */
    public function download(string $filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            return back()->with('error', 'Backup file not found.');
        }

        AuditLog::log(
            'backup.downloaded',
            'Database backup downloaded: ' . $filename
        );

        return response()->download($filepath);
    }

    /**
     * Delete a backup file
     */
    public function destroy(string $filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            return back()->with('error', 'Backup file not found.');
        }

        unlink($filepath);

        AuditLog::log(
            'backup.deleted',
            'Database backup deleted: ' . $filename
        );

        return back()->with('success', 'Backup deleted successfully.');
    }

    /**
     * Get list of backup files
     */
    protected function getBackupList(): array
    {
        $backups = [];
        $backupPath = storage_path('app/backups');

        if (!is_dir($backupPath)) {
            return $backups;
        }

        $files = scandir($backupPath, SCANDIR_SORT_DESCENDING);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $filepath = $backupPath . '/' . $file;
                $backups[] = [
                    'filename' => $file,
                    'size' => filesize($filepath),
                    'created_at' => date('Y-m-d H:i:s', filemtime($filepath)),
                ];
            }
        }

        return $backups;
    }
}
