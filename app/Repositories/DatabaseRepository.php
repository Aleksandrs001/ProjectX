<?php declare(strict_types=1);

namespace App\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;

class DatabaseRepository
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        $dotenv = Dotenv::createImmutable('dotenv');
        if (self::$connection == null) {
            $connectionParams = [
                'dbname' => $dotenv->load()["DBNAME"],
                'user' => $dotenv->load()["USER"],
                'password' => $dotenv->load()["DB_KEY"],
                'host' => $dotenv->load()["HOST"],
                'driver' => $dotenv->load()["DRIVER"],
            ];
            self::$connection = DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}
