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
                    'id' => 'delete-form',
                ]);
                ?>
                <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
                <?= Html::submitButton('Вы действительно хотите удалить этот пост?', ['class' => 'btn btn-primary']) ?>
                <?= Html::errorSummary($model) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
