<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class ExportSqlDummy extends Command
{
    protected $signature = 'export:sql-dummy';
    protected $description = 'Export all tables with data to a dummy SQL file';

    public function handle()
    {
        $dbName = env('DB_DATABASE', config('database.connections.mysql.database'));
        $tables = array_map(function($t) { return $t['name']; }, array_filter(Schema::getTables(), function($t) use ($dbName) { return $t['schema'] === $dbName || strpos($t['schema_qualified_name'], $dbName . '.') !== false; }));
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $rows = DB::table($table)->get();
            if ($rows->isEmpty()) {
                continue;
            }

            $sql .= "-- Dumping data for table: {$table}\n";
            $sql .= "TRUNCATE TABLE `{$table}`;\n";
            
            foreach ($rows as $row) {
                $rowArray = (array) $row;
                $keys = array_keys($rowArray);
                $values = array_map(function($value) {
                    if (is_null($value)) return "NULL";
                    $value = addslashes($value);
                    $value = str_replace("\n", "\\n", $value);
                    $value = str_replace("\r", "\\r", $value);
                    return "'" . $value . "'";
                }, array_values($rowArray));

                $sql .= "INSERT INTO `{$table}` (`" . implode("`, `", $keys) . "`) VALUES (" . implode(", ", $values) . ");\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        File::put(base_path('dummy_erp_data.sql'), $sql);
        $this->info('SQL Dummy successfully generated at: ' . base_path('dummy_erp_data.sql'));
    }
}
