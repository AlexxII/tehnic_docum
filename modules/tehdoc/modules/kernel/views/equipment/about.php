<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="container-fluid col-lg-6 col-md-6">
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => 'Категория:',
            'value' => $model->SubcategoryTitle,
        ],
        'eq_title',
        'eq_manufact',
        'eq_model',
        'eq_serial',
        [
            'label' => 'Место размещения:',
            'value' => $model->place,
        ],
        [
            'label' => 'Изображения:',
            'format' => 'raw',
            'value' => $model->photos ? '<a href="#" style="color: #3f51b5">' . count($model->photos) . ' штук(и)' . '</a>' : 'отсутствуют',
        ]
    ],
]) ?>
</div>
