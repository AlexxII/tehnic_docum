<?php

use yii\helpers\Html;

$this->title = 'Добавить предстоящий сеанс';
$this->params['breadcrumbs'][] = ['label' => 'Журнал', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tool-create">

    <div class="col-lg-7 col-md-7" style="border-radius: 2px">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
