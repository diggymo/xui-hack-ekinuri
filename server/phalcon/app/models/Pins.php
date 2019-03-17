<?php

class Pins extends ModelBase
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
     * @var integer
     */
    public $station_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    public $created_at;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("pins");
        $this->belongsTo('user_id', '\Users', 'id', ['alias' => 'user']);
        $this->belongsTo('station_id', '\Stations', 'id', ['alias' => 'station']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pins';
    }

    public function jsonSerialize()
    {
        $jsonArray = parent::jsonSerialize();
        $jsonArray["station"] = $this->station->jsonSerialize();
        $jsonArray["user"] = $this->user->jsonSerialize();
        return $jsonArray;
    }
}
