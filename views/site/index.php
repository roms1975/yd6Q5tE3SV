<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;;
?>
<div class="site-index">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                1
            </div>
            <div class="col-md-6">
                <?= $this->render('_post_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>
