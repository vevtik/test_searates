<?php

namespace app\db;

class DBFactory
{
    /**
     * @var DBAdapterInterface
     */
    private static DBAdapterInterface $instance;

    private static function connect(): void
    {
        $dbDriverClass = DB_DRIVER;
        self::$instance = new $dbDriverClass();
        self::$instance->connect(DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * @return DBAdapterInterface
     */
    public static function getInstance(): DBAdapterInterface
    {
        if (empty(self::$instance)) {
            self::connect();
        }

        return self::$instance;
    }
}
