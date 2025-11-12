<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $text
 * @property string|null $ip
 * @property string|null $created
 * @property string|null $updated
 */
class Post extends \yii\db\ActiveRecord
{
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'text', 'ip', 'updated'], 'default', 'value' => null],
            [['text'], 'string'],
            [['created', 'updated'], 'safe'],
            [['name', 'email', 'ip'], 'string', 'max' => 255],
            ['verifyCode', 'captcha']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя автора',
            'email' => 'Email',
            'text' => 'Сообщение',
            'ip' => 'Ip',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

}
