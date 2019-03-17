<?php

/**
 * migrationのutilクラス
 * Class MigrationUtil
 */
class MigrationUtil
{
    public static function isProductionMode()
    {
        if (!getenv("MODE")) {
            /**
             * Dotenv loading
             */
            $dotenv = new \Dotenv\Dotenv(__DIR__ . "/../..");
            $dotenv->load();
        }

        return getenv("MODE") == "production";
    }
}
