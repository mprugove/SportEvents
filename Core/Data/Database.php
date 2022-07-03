<?php

namespace Core\Data;

use App\Credentials;
use PDO;

final class Database extends PDO
{
    private static $instance;

    protected function __construct()
    {
        $dsn = 'mysql:host=' . Credentials::DB_HOST . ';dbname=' . Credentials::DB_NAME . ';charset=utf8';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => TRUE,
            PDO::ATTR_PERSISTENT => TRUE
        ];

        parent::__construct($dsn, Credentials::DB_USER, Credentials::DB_PASSWORD, $options);
    }

    protected function __clone() { }

    public static function getInstance(): self
    {
        if (static::$instance === null)
        {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
