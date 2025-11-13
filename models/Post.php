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
            [['name', 'email', 'text'], 'required'],
            [['name'], 'string', 'min' => 2, 'max' => 15],
            ['text', 'filter', 'filter' => 'trim'],
            [['text'], 'string', 'min' => 5, 'max' => 1000],
            [['email'], 'email'],
            //[['name', 'email', 'text', 'ip', 'updated'], 'default', 'value' => null],
            [['created', 'updated'], 'safe'],
            [['name', 'email', 'ip'], 'string', 'max' => 255],
            ['verifyCode', 'captcha'],
            ['ip', 'checkTimeout']
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
            'verifyCode' => 'Код с картинки'
        ];
    }

    public function checkTimeout($attribute)
    {
        $timeout = Yii::$app->params['postTimeOut'];
        $row = static::find()
            ->where(['ip' => $this[$attribute]])
            ->orderBy(['created' => SORT_DESC])
            ->one();

        if ($row) {
            $time = strtotime('now') - strtotime($row['created']);

            if ($time < $timeout) {
                $left = $timeout - $time;
                $this->addError($attribute, "Следующее сообщение можно опубликовать через {$left} секунд.");
                return false;
            }
        }

        return true;
    }

}
