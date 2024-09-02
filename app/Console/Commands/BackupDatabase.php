<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup the database to individual SQL files for each table with structure and data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Fetch the tables from the current database
            $tables = DB::select('SHOW TABLES');
            $database = config('database.connections.mysql.database');

            // Create a new folder with the current date and time
            $timestamp = date('Y-M-d_H-i-s');
            $backupPath = storage_path("app/public/backup_{$timestamp}");

            // Ensure the backup directory exists
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $this->info("Creating backup folder at: {$backupPath}");

            // Loop through each table
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                $this->info("Backing up table: {$tableName}");

                // Get primary key column(s)
                $primaryKey = $this->getPrimaryKey($tableName);

                if ($primaryKey === null) {
                    $this->error("No primary key found for table: {$tableName}. Skipping table.");
                    continue;
                }

                // Fetch rows in chunks to avoid memory issues
                $chunkSize = 1000;
                $filePath = "{$backupPath}/{$tableName}.sql";
                $file = fopen($filePath, 'w');

                // Write table creation statement
                $createTableSql = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{'Create Table'};
                fwrite($file, "{$createTableSql};\n\n");

                // Write table data
                $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
                $insertSql = "INSERT INTO `{$tableName}` (`" . implode('`, `', $columns) . "`) VALUES\n";

                // Ensure orderBy clause to use chunk
                DB::table($tableName)
                    ->orderBy($primaryKey) // Use the primary key for ordering
                    ->chunk($chunkSize, function ($rows) use ($file, $insertSql) {
                        $values = [];

                        foreach ($rows as $row) {
                            $escapedRow = array_map(function ($value) {
                                return DB::connection()->getPdo()->quote($value);
                            }, (array) $row);
                            $values[] = '(' . implode(', ', $escapedRow) . ')';
                        }

                        fwrite($file, $insertSql . implode(",\n", $values) . ";\n\n");
                    });

                fclose($file);
                $this->info("Table backup completed: {$filePath}");
            }

            $this->info("All tables have been backed up successfully.");
        } catch (\Exception $e) {
            $this->error('Failed to backup tables: ' . $e->getMessage());
        }
    }

    /**
     * Get the primary key column(s) for a given table.
     *
     * @param string $tableName
     * @return string|null
     */
    private function getPrimaryKey($tableName)
    {
        $primaryKey = DB::selectOne("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = ?
            AND CONSTRAINT_NAME = 'PRIMARY'
            AND TABLE_SCHEMA = ?",
            [$tableName, config('database.connections.mysql.database')]
        );

        return $primaryKey ? $primaryKey->COLUMN_NAME : null;
    }
}
