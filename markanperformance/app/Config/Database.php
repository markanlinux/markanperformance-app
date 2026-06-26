<?php

namespace App\Config;

class Database
{
    private static ?\mysqli $connection = null;

    private const HOST     = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DATABASE = "markanperformance";

    public static function getConnection(): \mysqli
    {
        if (self::$connection === null) {
            self::$connection = new \mysqli(
                self::HOST,
                self::USERNAME,
                self::PASSWORD,
                self::DATABASE
            );

            if (self::$connection->connect_error) {
                die("Greška pri spajanju na bazu podataka: " . self::$connection->connect_error);
            }

            self::$connection->set_charset("utf8mb4");
        }

        return self::$connection;
    }
}
