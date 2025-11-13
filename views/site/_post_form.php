<?php
    
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php 
    $form = ActiveForm::begin([
    'id' => 'post-form',
]);
?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
<?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
<?= Html::errorSummary($model) ?>
<?php ActiveForm::end(); ?>