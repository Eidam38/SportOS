<?php

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $host = 'db';
            $dbName = $_ENV['MYSQL_DATABASE'] ?? 'sportos_db';
            $user = $_ENV['MYSQL_USER'] ?? 'sportos_app';
            $password = $_ENV['MYSQL_PASSWORD'] ?? '';

            $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

            self::$connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$connection;
    }
}