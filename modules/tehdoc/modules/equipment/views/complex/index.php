<?php

use yii\helpers\Html;

$this->title = 'Комплекты оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

$about = 'Комплектное оборудование';
$add_hint = 'Добавить оборудование';
$dell_hint = 'Удалить выделенное оборудование';
$classif_hint = 'Присвоить выделенному оборудованию пользовательский классификатор';
?>

<div class="to-schedule-archive">

    <h1><?= Html::encode($this->title) ?>
        <sup class="h-title fa fa-info-circle" aria-hidden="true"
             data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup></h1>

</div>

<style>
    .h-title {
        font-size: 18px;
        color: #1e6887;
    }
</style>

<div class="row">
    <div class="">
        <div class="container-fluid" style="margin-bottom: 20px">
            <?= Html::a('Добавить',
                ['create'], [
                    'class' => 'btn btn-success btn-sm',
                    'style' => ['margin-top' => '5px'],
                    'data-toggle' => "tooltip",
                    'data-placement' => "top",
                    'title' => $add_hint,
                ]) ?>
            <?= Html::a('Удалить',
                [''], [
                    'class' => 'btn btn-danger btn-sm hiddendel',
                    'style' => ['margin-top' => '5px', 'display' => 'none'],
                    'data-toggle' => "tooltip",
                    'data-placement' => "top",
                    'title' => $dell_hint,
                ]) ?>
            <?= Html::a('Классиф-тор',
                [''], [
                    'class' => 'btn btn-info btn-sm classif',
                    'style' => ['margin-top' => '5px', 'display' => 'none'],
                    'data-toggle' => "tooltip",
                    'data-placement' => "top",
                    'title' => $classif_hint,
                ]) ?>
        </div>
    </div>
    <div class="container-fluid">

    </div>
</div>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>