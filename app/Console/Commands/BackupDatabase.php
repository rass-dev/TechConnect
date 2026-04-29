<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    // Command signature
    protected $signature = 'db:backup';

    // Command description
    protected $description = 'Backup the entire database';

    public function handle()
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Backup file path
        $backupPath = storage_path('app/db_backups/');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . $fileName;

        // Build the mysqldump command
        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} --port={$dbPort} {$dbName} > {$filePath}";

        $returnVar = null;
        $output = null;

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Database backup successful! File saved: {$filePath}");
        } else {
            $this->error("Database backup failed!");
        }
    }
}