<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tehdoc\asset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Техническая документация';
$about = 'На представленные данные опирается все приложение.
Корректность этих данных - залог успешной работы системы.';

$add_hint = 'Добавить оборудование';
$dell_hint = 'Удалить выделенное оборудование';
$classif_hint = 'Присвоить выделенному оборудованию пользовательский классификатор';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="to-schedule-archive">
    <h1><?= Html::encode($this->title) ?>
</div>

<style>
    .h-title {
        font-size: 18px;
        color: #1e6887;
    }
    .placeholder {
        text-align: center;
    }
</style>


<div class="row">
    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="#"></a>
        <h2>Оборудование</h2>
        <span class="text-muted" style="font-size: 20px">Перечень оборудования</span>
    </div>

    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="#"></a>
        <h2>Документация</h2>
        <span class="text-muted" style="font-size: 20px">Перечень документации</span>
    </div>

    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="#"></a>
        <h2>Схемы</h2>
        <span class="text-muted" style="font-size: 20px">Перечень схем</span>
    </div>

    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="#"></a>
        <h2>ТО</h2>
        <span class="text-muted" style="font-size: 20px">Техническое обслуживание</span>
    </div>

    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="#"></a>
        <h2></h2>
        <span class="text-muted" style="font-size: 20px">Техническое обслуживание</span>
    </div>

</div>
<br>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
