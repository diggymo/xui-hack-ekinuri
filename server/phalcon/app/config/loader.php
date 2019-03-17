<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir
    ]
)->registerNamespaces([
    'App\Controllers' => __DIR__ . '/../controllers/',
    'App\Controllers\V1' => __DIR__ . '/../controllers/v1/',
    'App\Repositories' => __DIR__ . '/../repositories/',
    'App\Services' => __DIR__ . '/../services/',
    'App\Validations' => __DIR__ . '/../validations/',
    'App\Lib' => __DIR__ . '/../lib/'
])->register();
