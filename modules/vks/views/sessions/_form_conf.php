<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use app\modules\tehdoc\models\Equipment;

?>

<style>
    .fa {
        font-size: 15px;
        color: #FF0000;
    }
    .nonreq {
        color: #1e6887;
    }
    .select-selected {
        padding-left: 40px;
    }
    .form-group {
        margin-bottom: 5px;
    }
    .control-label {
        font-size: 14px;
    }
</style>

<?php

\yii\widgets\MaskedInputAsset::register($this);

$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС (Напрмер: ЗВС-ОГВ, КВС и т.д.)';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';
$vks_subscrof_hint = 'Укажите ведомство старшего абонента';
$vks_subscr_hint = 'Укажите Фамилию старшего абонента';
$vks_order_hint = 'Обязательное поле! Укажите ';
$vks_employee_hint = 'Обязательное поле! Укажите ';
$vks_subscriber_office_hint = '1';
$vks_subscriber_hint = '2';
$vks_equipment_hint = '3';

?>

<div class="col-lg-7 col-md-7" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>

    <div class="form-group">
        <div class="form-group col-md-7 col-lg-7">
            <?= $form->field($model, 'vks_date', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_date_hint . '"></sup>{input}{hint}'
            ])->textInput([
                'class' => 'fact-date form-control'
            ])->hint('', ['class' => ' w3-label-under']); ?>
    </div>

    <div class="form-group">
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_teh_time_start')->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_teh_time_end')->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_work_time_start')->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_work_time_end')->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>


    <div class="form-group col-md-12 col-lg-12">
        <?php
        echo $form->field($model, 'vks_type', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_type_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksTypesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_place', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_place_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksPlacesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="form-group">
        <div class="form-group col-md-7 col-lg-7">
            <?= $form->field($model, 'vks_subscriber_office', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}{error}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                    'name' => 'placement_kv',
                    'asDropdown' => true,
                    'multiple' => false,
                    'fontAwesome' => true,
                    'rootOptions' => [
                        'label' => '<i class="fa fa-tree"></i>',
                    ]
                ]
            )->hint('', ['class' => ' w3-label-under']);
            ?>
        </div>
        <div class="form-group col-md-5 col-lg-5">
            <?= $form->field($model, 'vks_subscriber_name', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscr_hint . '"></sup>{input}{hint}'
            ])->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_order', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_order_hint . '"></sup>{input}{hint}{error}'
        ])->widget(\kartik\tree\TreeViewInput::class, [
                'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                'name' => 'placement_kv',
                'asDropdown' => true,
                'multiple' => false,
                'fontAwesome' => true,
                'rootOptions' => [
                    'label' => '<i class="fa fa-tree"></i>',
                ]
            ]
        )->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_employee', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_hint . '"></sup>{input}{hint}{error}'
        ])->widget(\kartik\tree\TreeViewInput::class, [
                'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                'name' => 'placement_kv',
                'asDropdown' => true,
                'multiple' => false,
                'fontAwesome' => true,
                'rootOptions' => [
                    'label' => '<i class="fa fa-tree"></i>',
                ]
            ]
        )->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="col-md-12 col-lg-12" style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 10px 0px;margin-bottom: 10px">
        <div class="form-group col-md-7 col-lg-7">
            <?= $form->field($model, 'vks_subscriber_name', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscriber_office_hint . '"></sup>{input}{hint}{error}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                    'name' => 'placement_kv',
                    'asDropdown' => true,
                    'multiple' => false,
                    'fontAwesome' => true,
                    'rootOptions' => [
                        'label' => '<i class="fa fa-tree"></i>',
                    ]
                ]
            )->hint('', ['class' => ' w3-label-under']);
            ?>
        </div>
        <div class="form-group col-md-5 col-lg-5">
            <?= $form->field($model, 'vks_subscriber_name', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscriber_hint . '"></sup>{input}{hint}'
            ])->textInput()->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_equipment', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_equipment_hint . '"></sup>{input}{hint}{error}'
        ])->widget(\kartik\tree\TreeViewInput::class, [
                'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                'name' => 'placement_kv',
                'asDropdown' => true,
                'multiple' => false,
                'fontAwesome' => true,
                'rootOptions' => [
                    'label' => '<i class="fa fa-tree"></i>',
                ]
            ]
        )->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_remarks')->checkbox(); ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_comments')->textArea(array('style' =>'resize:vertical', 'rows' => '5')) ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#w1-tree-input-menu').on('change', function (e) {
            var text = $('#w1-tree-input').text();
            console.log(text);
            $('#equipment-eq_title').val(text);
        });
    });

    $(document).ready(function () {
        $('.fact-date').datepicker({
            format: 'd MM yyyy г.',
            autoclose: true,
            language: "ru",
            startView: "days",
            minViewMode: "days",
            clearBtn: true,
            todayHighlight: true,
            daysOfWeekHighlighted: [0,6]

        })
    });

    $(document).ready(function () {
        if ($('.fact-date').val()) {
            var date = new Date($('.fact-date').val());
            moment.locale('ru');
            $('.fact-date').datepicker('update', moment(date).format('MMMM YYYY'))
        }
    });

    //преобразование дат перед отправкой
    $(document).ready(function () {
        $('#w0').submit(function () {
            var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.fact-date').val(d);
        });
    });

    $(document).ready(function () {
        var variable = [];
        var cats, leaves, del = [];
        $.ajax("/admin/category/get-leaves")
            .done(function (data) {
                data = jQuery.parseJSON(data);
                cats = data.cat;
                leaves = data.leaves;
                for (var i = 0; i < cats.length; i++) {
                    variable[i] = cats[i].id;
                }
                for (var i = 0; i < leaves.length; i++) {
                    del[i] = leaves[i].id;
                }
                variable.forEach(function (t) {
                    if (contains(del, t)) {
                        return;
                    }
                    var element = $("select option[value='" + t + "']");
                    $("select option[value='" + t + "']").attr('disabled', true);
                    $("select option[value='" + t + "']").css({
                        "background-color": '#e8e8e8',
                        "font-weight": 700
                    });
                });
            })
            .fail(function () {
//                alert( "Произошда ошибка в выводе категорий." );
            })
            .always(function () {
//                alert( "complete" );
            });

    });

    function contains(arr, elem) {
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] === elem) {
                return true;
            }
        }
        return false;
    }

</script>

