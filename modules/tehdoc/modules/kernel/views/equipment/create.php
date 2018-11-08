<?php

use yii\helpers\Html;

$this->title = 'Добавить оборудование';
$this->params['breadcrumbs'][] = ['label' => 'Тех Док', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Основное оборудование', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tool-create">

  <div class="col-lg-7 col-md-7" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?></h1>
  </div>

  <?= $this->render('_form', [
      'model' => $model,
      'fUpload' => $fupload
  ]) ?>

</div>
