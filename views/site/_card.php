<?php

use app\helpers\PluralizeHelper;

$maskIp = '';

/* маскируем ip */
if (!empty($post['ip'])) {
    if (strpos($post['ip'], ':')) {
        $arr = explode(':', $post['ip']);
        $length = count($arr);

        if ($length > 4) {
            for ($i = 1; $i < 5; $i++) {
                $arr[($length - $i)] = '***';
            }
            $maskIp = implode(':', $arr);
        }
    } else {
        $maskIp = preg_replace('/(\d{1,3}\.\d{1,3}\.)\d{1,3}\.\d{1,3}/', '${1}**.**', $post['ip']);
    }
}

?>

<div class="card card-default">
    <?php if (isset($post['imageUrl'])): ?>
        <img src="<?= $post['imageUrl'] ?>" class="card-img-top" alt="Изображение от {{author}}">
    <?php endif; ?>
    <div class="card-body">
        <h5 class="card-title"><?= $post['name'] ?></h5>
        <p><?= $post['text'] ?></p>
        <p>
            <small class="text-muted">
                <?= Yii::$app->formatter->format($post['created'], 'relativeTime'); ?> |
                <?= $maskIp ?> |
				<?php
                    echo (isset($statistic[$post['email']]) ?
                        $statistic[$post['email']] . ' ' .
                        PluralizeHelper::pluralize($statistic[$post['email']],
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