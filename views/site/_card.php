<?php

use app\helpers\PluralizeHelper;

$maskIp = '';

/* маскируем ip */
if (!empty($model['ip'])) {
    if (strpos($model['ip'], ':')) {
        $arr = explode(':', $model['ip']);
        $length = count($arr);

        if ($length > 4) {
            for ($i = 1; $i < 5; $i++) {
                $arr[($length - $i)] = '***';
            }
            $maskIp = implode(':', $arr);
        }
    } else {
        $maskIp = preg_replace('/(\d{1,3}\.\d{1,3}\.)\d{1,3}\.\d{1,3}/', '${1}**.**', $model['ip']);
    }
}

$css = <<<CSS
.pagination {
    margin-top: 10px;
}
.pagination li>a {
    padding: 5px 8px;
    margin: 5px;
    background-color: #dddddd;
    border-radius: 3px;
}
.pagination li.active>a {
    color: white;
    background-color: #0d6efd;
}

CSS;

$this->registerCss($css);

?>

<div class="card card-default">
    <?php if (isset($model['imageUrl'])): ?>
        <img src="<?= $model['imageUrl'] ?>" class="card-img-top" alt="Изображение от {{author}}">
    <?php endif; ?>
    <div class="card-body">
        <h5 class="card-title"><?= $model['name'] ?></h5>
        <p><?= $model['text'] ?></p>
        <p>
            <small class="text-muted">
                <?= Yii::$app->formatter->format($model['created'], 'relativeTime'); ?> |
                <?= $maskIp ?> |
				<?php
                    echo (isset($statistic[$model['email']]) ?
                        $statistic[$model['email']] . ' ' .
                        PluralizeHelper::pluralize($statistic[$model['email']],
                            [
                                'пост',
                                'поста',
                                'постов'
                            ]):
                        '');
                ?>
            </small>
        </p>
    </div>
</div>