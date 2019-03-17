<?php

use Phalcon\Db\RawValue;

class Stations extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="ruby", type="string", length=255, nullable=false)
     */
    public $ruby;

    /**
     *
     * @var string
     * @Column(column="position", type="string", nullable=false)
     */
    public $position;

    /**
     *
     * @var string
     * @Column(column="lat", type="string", length=8, nullable=false)
     */
    public $lat;

    /**
     *
     * @var string
     * @Column(column="lng", type="string", length=9, nullable=false)
     */
    public $lng;

    /**
     *
     * @var integer
     * @Column(column="prefecture", type="integer", length=11, nullable=false)
     */
    public $prefecture;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    public $label;

    /**
     * 位置情報を入力する
     * @param $lat
     * @param $lng
     * @return $this
     */
    public function setPosition($lat, $lng)
    {
        // TODO mysql8ではST_GeomFromText()
        $this->position = new RawValue("GeomFromText('POINT(" . $lat . " " . $lng . ")')");

        $this->lat = $lat;
        $this->lng = $lng;
        return $this;
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("stations");
//        $this->hasMany('id', '\Users', 'frequently_drinking_station_id', ['alias' => 'FrequentlyDrinkingStation']);
//        $this->hasMany('id', '\Users', 'nearest_station_id', ['alias' => 'NearestStation']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'stations';
    }

    /**
     * jsonに変換
     * @return array
     */
    public function jsonSerialize()
    {
        $jsonArray = parent::jsonSerialize();
        $jsonArray['lat'] = (double)$jsonArray['lat'];
        $jsonArray['lng'] = (double)$jsonArray['lng'];
        // バイナリなので無視
        unset($jsonArray['position']);
        return $jsonArray;
    }
}
