<?php

use App\Services\CustomerService;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\InclusionIn;

class Users extends ModelBase
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $region;

    /**
     *
     * @var string
     */
    public $team;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $deleted_at;

    /**
     *
     * @var string
     */
    public $last_communicated_at;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();
//
//        $validator->add(
//            'email',
//            new EmailValidator(
//                [
//                    'model' => $this,
//                    'message' => 'メールアドレスの形式が不正です',
//                ]
//            )
//        );
//
//        // Uniquenessだと論理削除がきかないため、callbackを採用
//        $validator->add(
//            'email',
//            new Callback(
//                [
//                    'model' => $this,
//                    'message' => 'このメールアドレスはすでに登録されています',
//                    'callback' => function ($model) {
//                        return !CustomerService::g()->isDuplicatedEmail($model->email, $model);
//                    }
//                ]
//            )
//        );
//
//
//        $validator->add(
//            'role',
//            new InclusionIn(
//                [
//                    'domain' => [
//                        'USER',
//                        'FRANCHISE',
//                        'CORPORATION',
//                        'ADMIN'
//                    ],
//                    'message' => '権限が設定されていません',
//                ]
//            )
//        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
//        $this->belongsTo('frequently_drinking_station_id', '\Stations', 'id', ['alias' => 'frequently_drinking_station']);
//        $this->belongsTo('frequently_drinking_station_id2', '\Stations', 'id', ['alias' => 'frequently_drinking_station2']);
//        $this->belongsTo('frequently_drinking_station_id3', '\Stations', 'id', ['alias' => 'frequently_drinking_station3']);
//        $this->belongsTo('frequently_drinking_station_id4', '\Stations', 'id', ['alias' => 'frequently_drinking_station4']);
//        $this->belongsTo('frequently_drinking_station_id5', '\Stations', 'id', ['alias' => 'frequently_drinking_station5']);
//        $this->belongsTo('nearest_station_id', '\Stations', 'id', ['alias' => 'nearest_station']);
//        $this->belongsTo('corporation_id', '\Corporations', 'id', ['alias' => 'corporations']);
//        $this->belongsTo('franchise_id', '\Franchises', 'id', ['alias' => 'franchises']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

//    public function jsonSerialize()
//    {
//        $jsonArray = parent::jsonSerialize();
//
//        // UUIDを表示
//        $jsonArray['id'] = $jsonArray['encrypted_id'];
//        $jsonArray['sex'] = (int)$jsonArray['sex'];
//
//        // 項目を削除
//        unset($jsonArray['password']);
//        unset($jsonArray['payment_customer_token']);
//        unset($jsonArray['payment_subscription_token']);
//        unset($jsonArray['payment_cycle_anchor']);
//        unset($jsonArray['name']);
//        unset($jsonArray['role']);
//        unset($jsonArray['franchise_id']);
//        unset($jsonArray['corporation_id']);
//        unset($jsonArray['encrypted_id']);
//        unset($jsonArray['deleted_at']);
//
//        // 駅情報はフォーマットして表示
//        unset($jsonArray['nearest_station_id']);
//        unset($jsonArray['frequently_drinking_station_id']);
//        unset($jsonArray['frequently_drinking_station_id2']);
//        unset($jsonArray['frequently_drinking_station_id3']);
//        unset($jsonArray['frequently_drinking_station_id4']);
//        unset($jsonArray['frequently_drinking_station_id5']);
//        $jsonArray['nearest_station'] = $this->nearest_station
//            ? $this->nearest_station->jsonSerialize()
//            : null;
//        $jsonArray['frequently_drinking_station'] = $this->frequently_drinking_station
//            ? $this->frequently_drinking_station->jsonSerialize()
//            : null;
//
//        $jsonArray['optional_frequently_drinking_stations'] = $this->getOptionalFrequencyStationArray();
//
//        return $jsonArray;
//    }
//
//
//    public function jsonSerializeForUser()
//    {
//        return [
//            "id" => $this->encrypted_id,
//            "created_at" => $this->created_at,
//            "updated_at" => $this->updated_at,
//            "email" => $this->email
//        ];
//    }
//
//    /**
//     * 論理削除
//     * @return bool
//     */
//    public function delete()
//    {
//        $this->payment_customer_token = null;
//        $this->payment_subscription_token = null;
//        return $this->softDelete();
//    }
//
//    public static function query(\Phalcon\DiInterface $dependencyInjector = null, $isIncludeDeleted = false)
//    {
//        $query = parent::query($dependencyInjector);
//        if (!$isIncludeDeleted) {
//            return $query->andWhere("Users.deleted_at IS NULL");
//        }
//        return $query;
//    }
//
//    /**
//     * Allows to query the first record that match the specified conditions
//     *
//     * @param mixed $parameters
//     * @return Users|\Phalcon\Mvc\Model\ResultInterface
//     */
//    public static function findFirst($parameters = null)
//    {
//        $parameters = parent::appendParams($parameters, "Users.deleted_at IS NULL");
//        return parent::findFirst($parameters);
//    }
//
//    /**
//     * よく飲む駅を複数取得
//     * @return array
//     */
//    public function getOptionalFrequencyStationArray()
//    {
//        $frequencyStationArray = [];
//        if ($this->frequently_drinking_station_id2) {
//            $frequencyStationArray[] = $this->frequently_drinking_station2;
//        }
//
//        if ($this->frequently_drinking_station_id3) {
//            $frequencyStationArray[] = $this->frequently_drinking_station3;
//        }
//
//        if ($this->frequently_drinking_station_id4) {
//            $frequencyStationArray[] = $this->frequently_drinking_station4;
//        }
//
//        if ($this->frequently_drinking_station_id5) {
//            $frequencyStationArray[] = $this->frequently_drinking_station5;
//        }
//
//        return $frequencyStationArray;
//    }
}
