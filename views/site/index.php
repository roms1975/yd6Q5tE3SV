<?php

use \yii\widgets\LinkPager;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>

<div class="site-index">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_card',
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->render('_post_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>
