<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

/**
 * Composer autoload
 */
require_once APP_PATH . '/../vendor/autoload.php';

if (!getenv("DB_HOST")) {
    /**
     * Dotenv loading
     */
    $dotenv = new Dotenv\Dotenv(__DIR__ . "/../..");
    $dotenv->load();
}

return new \Phalcon\Config([
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => getenv("DB_HOST"),
        'username'   => getenv("DB_USERNAME"),
        'password'   => getenv("DB_PASSWORD"),
        'dbname'     => getenv("DB_NAME"),
        'port'       => getenv("DB_PORT"),
        'charset'    => getenv("DB_CHARSET"),
        'options'  => [
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
        ]
    ],

    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'controllersDir' => APP_PATH . '/controllers/',
        'baseUri'        => '/',
    ]
]);
