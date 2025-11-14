<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;
use yii\behaviors\TimestampBehavior;

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
class Post extends ActiveRecord
{
    public $verifyCode;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
                'value' => time(),
            ],
        ];
    }

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
            ['text', 'filter', 'filter' => function($value) {
                return HtmlPurifier::process($value, [
                    'HTML.AllowedElements' => ['b', 'i', 's'],
                ]);
            }],
            [['text'], 'string', 'min' => 5, 'max' => 1000],
            [['email'], 'email'],
            [['created', 'updated'], 'safe'],
            [['name', 'email', 'ip'], 'string', 'max' => 255],
            ['verifyCode', 'captcha'],
            ['ip', 'checkTimeout', 'on' => self::SCENARIO_CREATE],
            ['ip', 'checkTimeoutUpdate', 'on' => self::SCENARIO_UPDATE],
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
            'created' => 'Создано',
            'updated' => 'Обновлено',
            'verifyCode' => 'Код с картинки'
        ];
    }

    public function checkTimeout($attribute)
    {
        $timeout = Yii::$app->params['postTimeOut'];
        $row = static::find()
            ->where([$attribute => $this[$attribute]])
            ->orderBy(['created' => SORT_DESC])
            ->one();

        if ($row) {
            $time = time() - $row['created'];

            if ($time < $timeout) {
                $left = $timeout - $time;
                $this->addError($attribute, "Следующее сообщение можно опубликовать через {$left} секунд.");
                return false;
            }
        }

        return true;
    }

    public function checkTimeoutUpdate($attribute)
    {
        $timeout = Yii::$app->params['postTimeOut'];
        $row = static::find()
            ->where([$attribute => $this[$attribute]])
            ->orderBy(['created' => SORT_DESC])
            ->one();

        if ($row) {
            $time = time() - $row['created'];

//            if ($time < $timeout) {
//                $left = $timeout - $time;
//                $this->addError($attribute, "Следующее сообщение можно опубликовать через {$left} секунд.");
//                return false;
//            }
        }

        return true;
    }

}
