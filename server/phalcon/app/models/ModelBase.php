<?php

use Phalcon\Mvc\Model;

class ModelBase extends Model
{
    use Phalcon\Mvc\Model\EagerLoadingTrait;

    public function jsonSerialize()
    {
        $jsonArray = parent::jsonSerialize();
        $jsonArray['id'] = (int)$jsonArray['id'];
        return $jsonArray;
    }

    /**
     * $paramsの型に応じた方法でパラメーターを追記する。
     * @param  array|string $params 追記先のパラメーター
     * @param  string $append_param 追記するパラメーター
     * @return array|string 追記されたパラメーター
     */
    protected static function appendParams($params, $append_param)
    {
        if ($params === null) {
            $params = $append_param;

        } elseif (is_array($params)) {
            if (isset($params[0])) {
                $params[0] .= ' AND ' . $append_param;
            } elseif (isset($params['conditions'])) {
                $params['conditions'] .= ' AND ' . $append_param;
            } else {
                $params['conditions'] = $append_param;
            }

        } else {
            $params .= ' AND ' . $append_param;
        }

        return $params;
    }

    /**
     * deleted_atを更新
     * @return bool
     */
    protected function softDelete()
    {
        $this->deleted_at = date("Y-m-d H:i:s");
        if (!$this->update()) {
            return false;
        }
        return true;
    }
}
