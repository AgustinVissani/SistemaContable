<?php

namespace App\Helpers;
use Config;
use DB;

class DatabaseConnection
{
    public static function setConnection($nombreDB)
    {
        config(['database.connections.mysql4' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3307'),
            'database' => $nombreDB,
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'dump' => [
                'dump_binary_path' => 'E:\\xampp\\mysql\\bin',
                'use_single_transaction',
                'timeout' => 60 * 5, // 5 minute timeout
            ],
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]]);

        //return DB::connection('mysql2');
    }
}
