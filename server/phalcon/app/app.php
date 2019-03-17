<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */
use App\Controllers\BaseController;
use App\Services\SessionService;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View\Simple;
use Phalcon\Session\Adapter\Files as Session;

// セッションの初期設定$
$di->set(
    'session',
    function () {
        $session = new Session();
        $session->start();
        return $session;
    }
);

// トランザクション
$di->setShared(
    'transactions',
    function () {
        return new Manager();
    }
);

$di->setShared(
    'view',
    function () {
        $view = new Simple();

        $view->registerEngines(
            [
                '.volt' => Phalcon\Mvc\View\Engine\Volt::class,
            ]
        );
        $view->setViewsDir('../app/views/');

        return $view;
    }
);

$router = new Router();

$app->options('/(.*)', function () use ($app) {
    $app->response->sendHeaders();
});

/**
 * ルーティングの設定
 */
include APP_PATH . "/config/router.php";


$app->setService('router', $router, true);
