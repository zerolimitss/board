<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Ad extends ActiveRecord
{
    public static function tableName()
    {
        return "ads";
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['title', 'string', 'max' => 255],
            ['text', 'string'],
        ];
    }
}
