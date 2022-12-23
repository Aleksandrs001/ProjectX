<?php declare(strict_types=1);

namespace App\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DatabaseRepository
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        if (self::$connection == null) {
            $connectionParams = [
                'dbname' => $_ENV["DBNAME"],
                'user' => $_ENV["USER"],
                'password' => $_ENV["DB_KEY"],
                'host' => $_ENV["HOST"],
                'driver' => $_ENV["DRIVER"],
            ];
            self::$connection = DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}
