<?php

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
        <img src="{{imageUrl}}" class="card-img-top" alt="Изображение от {{author}}">
    <?php endif; ?>
    <div class="card-body">
        <h5 class="card-title"><?= $post['name'] ?></h5>
        <p><?= $post['text'] ?></p>
        <p>
            <small class="text-muted">
                <?= $post['created'] ?> |
                <?= $maskIp ?> |
				несколько постов
            </small>
        </p>
    </div>
</div>