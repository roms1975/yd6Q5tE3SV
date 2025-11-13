<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->name;
?>

<div class="site-index">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'update-form',
                ]);
                ?>
                <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                <?= Html::errorSummary($model) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
