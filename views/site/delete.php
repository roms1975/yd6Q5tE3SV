<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->name;
?>

<div class="site-index">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <p>Вы действительно хотите удалить этот пост?</p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'delete-form',
                ]);
                ?>
                <?= Html::hiddenInput('confirm-delete', 1) ?>
                <?= $this->render('_card', ['model' => $model]) ?>
                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
                <?= Html::submitButton('Удалить', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
                <?= Html::a('Отмена', ['site/index'],['class' => 'btn btn-info']) ?>

            </div>
        </div>
    </div>
</div>
