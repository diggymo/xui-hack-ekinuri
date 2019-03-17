<?php
use App\Controllers\BaseController;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

const V1_PREFIX_URL = "/api/v1";
const V1_NAMESPACE = "App\Controllers\V1\\";


/**
 * ACLとルーティング設定
 */
$stations = new MicroCollection();
$stations->setHandler(V1_NAMESPACE . 'StationsController', true);
$stations->setPrefix(V1_PREFIX_URL . '/stations');
$stations->get('/', 'search');
$app->mount($stations);

$session = new MicroCollection();
$session->setHandler(V1_NAMESPACE . 'SessionController', true);
$session->setPrefix(V1_PREFIX_URL . '/session');
$session->post('/', 'login');
$app->mount($session);


$pin = new MicroCollection();
$pin->setHandler(V1_NAMESPACE . 'PinController', true);
$pin->setPrefix(V1_PREFIX_URL . '/pin');
$pin->get('/', 'search');
$pin->post('/', 'create');
$app->mount($pin);

/**
 * notfoundとエラー時を定義
 * TODO インスタンス作成せずにスマートにできないか
 */
$app->notFound(
    function () use ($app) {
        $controller = new BaseController();
        return $controller->error(404)->send();
    }
);
$app->error(
    function (Exception $exception) {
        $controller = new BaseController();
        if (getenv('MODE') == 'development') {
            var_dump($exception);
        }
        return $controller->error(500)->send();
    }
);
