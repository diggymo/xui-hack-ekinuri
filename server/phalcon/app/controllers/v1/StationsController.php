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
        $stations = \Stations::query()->andWhere("prefecture=27")->execute();
        return $this->success($stations)->send();
    }
}