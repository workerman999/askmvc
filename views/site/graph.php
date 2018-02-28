<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Graph';

?>

<h3>Список мобильных объектов</h3>
<div class="col-lg-4">
    <?php foreach ($rezult as $item): ?>
        <h5><?= Html::a($item->text, ['site/graph'], [
                'data' => [
                    'method' => 'post',
                    'params' => [
                        'id' => $item->id,
                    ],
                ],
                ]); ?></h5>
    <?php endforeach; ?>
</div>

