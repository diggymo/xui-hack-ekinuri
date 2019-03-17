<?php

namespace App\Controllers\V1;

use App\Repositories\StationsRepository;

/**
 * Class StationsController
 */
class StationsController extends BaseV1Controller
{
    /**
     * @return \Phalcon\Http\Response
     */
    public function search()
    {
        $stations = \Stations::find([
            'prefecture' => 27
        ]);
        return $this->success($stations)->send();
    }
}