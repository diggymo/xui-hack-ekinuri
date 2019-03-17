<?php

namespace App\Controllers\V1;

use Phalcon\Mvc\Model\EagerLoading\Loader;
use Pins;

/**
 * Class PinController
 */
class PinController extends BaseV1Controller
{
    /**
     * ピンを取得
     * @return \Phalcon\Http\Response
     */
    public function search()
    {
        $pins = \Pins::query()->orderBy("created_at")->execute();
        $pins = Loader::fromResultset($pins, "user", "station");
        return $this->success($pins)->send();
    }

    /**
     * ピンの作成
     *
     * @return \Phalcon\Http\Response
     */
    public function create()
    {
        $params = $this->getJsonParam();

        $stationId = $params->station_id;
        $userId = $params->user_id;

        $pin = new Pins();
        $pin->station_id = $stationId;
        $pin->user_id = $userId;
        $pin->create();

        $this->success($pin)->send();
    }
}
