<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tehdoc\asset;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Просмотр';

$this->params['breadcrumbs'][] = ['label' => 'Тех Док', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Основное оборудование', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="to-schedule-archive">

  <h1><?= Html::encode($this->title) ?></h1>

</div>

<style>
  td {
    text-align: center;
  }

  .h-title {
    font-size: 18px;
    color: #1e6887;
  }

</style>


<div class="row">
  <div class="">
    <div class="container-fluid " style="margin-bottom: 20px">
      <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger btn-sm',
          'data' => [
              'confirm' => 'Вы уверены, что хотите удалить объект?',
              'method' => 'post',
          ],
      ]) ?>
    </div>
  </div>

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


  <div class="fotorama col-lg-6 col-md-6" data-allowfullscreen="native">
    <?php
      if ($photos = $model->photos){
        foreach ($photos as $photo) {
          echo '<img src='. $photo->getImageUrl() . '>';
        }
      }
    ?>
  </div>

</div>
<br>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


