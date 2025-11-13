<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class PostSearch extends Post
{
    static function postStatisic()
    {
        $result = self::find()
            ->select(['email', 'COUNT(*) AS total'])
            ->groupBy('email')
            ->asArray()
            ->all();

        return ArrayHelper::map($result, 'email', 'total');
    }


}