<?php
class Connection
{
    public static function get() : PDO
    {
        $pdo = new PDO("sqlite::memory:", null, null, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
        $pdo->exec("CREATE TABLE `sessions` 
            (
              `id` VARCHAR(512) PRIMARY KEY,
              `session_data` BLOB NOT NULL,
              `last_activity` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
        ");
        return $pdo;
    }
}