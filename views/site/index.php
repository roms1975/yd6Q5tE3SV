<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;;
?>
<div class="site-index">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <?php foreach ($posts as $post): ?>
                    <?= $this->render('_card', ['post' => $post]) ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <?= $this->render('_post_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>
