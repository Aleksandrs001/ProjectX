<?php declare(strict_types=1);

namespace App;

class  Session
{
    private static array $data = [];

    public static function initialize(): void
    {
        session_start();
        self::$data = $_SESSION;
    }

    public static function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return isset(self::$data[$key]);
    }
}