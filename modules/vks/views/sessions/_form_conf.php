<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use app\modules\tehdoc\models\Equipment;
use app\modules\vks\assets\FormAsset;

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
FormAsset::register($this);

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
            <?= $form->field($model, 'vks_teh_time_start')->textInput(['class' => 'time-mask form-control'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_teh_time_end')->textInput(['class' => 'time-mask form-control'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_work_time_start')->textInput(['class' => 'time-mask form-control'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'vks_work_time_end')->textInput(['class' => 'time-mask form-control'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?php
        echo $form->field($model, 'vks_type', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_type_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksTypesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_place', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_place_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksPlacesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_place_text]" id="vks_place_text" style="display: none">
    </div>

    <div class="form-group">
        <div class="form-group col-md-7 col-lg-7">
            <?= $form->field($model, 'vks_subscriber_office', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
            ])->dropDownList($model->vksMskSubscribesList, ['id' => 'subscriber-office', 'data-name' => 'vks_subscriber_office', 'prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
            ?>
            <input name="VksSessions[vks_subscriber_office_text]" id="vks_subscriber_office_text"
                   style="display: none">
        </div>
        <div class="form-group col-md-5 col-lg-5">
            <?= $form->field($model, 'vks_subscriber_name', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscr_hint . '"></sup>{input}{hint}'
            ])->textInput(['id'=> 'subscriber-name'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_order', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_order_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksOrdersList, ['data-name' => 'vks_order', 'prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_order_text]" id="vks_order_text" style="display: none">
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_employee', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksEmployees4List, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
    </div>

    <div class="col-md-12 col-lg-12" style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 10px 0px;margin-bottom: 10px">
        <div class="form-group col-md-7 col-lg-7">
            <?= $form->field($model, 'vks_subscriber_mur_office', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
            ])->dropDownList($model->vksRegionSubscribesList, ['id' => 'subscriber-mur-office', 'data-name' => 'vks_subscriber_mur_office', 'prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
            ?>
            <input name="VksSessions[vks_subscriber_mur_office_text]" id="vks_subscriber_mur_office_text"
                   style="display: none">

        </div>
        <div class="form-group col-md-5 col-lg-5">
            <?= $form->field($model, 'vks_subscriber_mur_name', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscriber_hint . '"></sup>{input}{hint}'
            ])->textInput(['id'=> 'subscriber-mur-name'])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_equipment', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksRegionSubscribesList, ['data-name' => 'vks_equipment', 'prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_equipment_text]" id="vks_equipment_text"
               style="display: none">

    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?php
        $template = [
            'labelOptions'=>['font-size'=>'28px'],
            'template' => '{label}{input}   ',
        ];
        echo $form->field($model, 'vks_remarks', $template)->checkbox(); ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_comments')->textArea(array('style' =>'resize:vertical', 'rows' => '5')) ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Подтвердить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function () {
        $(function () {
            $.mask.definitions['H'] = '[012]';
            $.mask.definitions['M'] = '[012345]';
            $('.time-mask').mask('H9:M9', {
                    placeholder: "_",
                    completed: function () {
                        console.log(this);
                        var val = $(this).val().split(':');
                        if (val[0] * 1 > 23) val[0] = '23';
                        if (val[1] * 1 > 59) val[1] = '59';
                        $(this).val(val.join(':'));
                        $(this).next('.time-mask').focus();
                        // $(this).next('.time-mask').focus();
                    }
                }
            );
        })
    });

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
        $.ajax({
            type: 'get',
            url: '/vks/sessions/subscribers-region',
            autoFocus: true,
            success: function (data) {
                var mskNames = $.parseJSON(data);
                $(function() {
                    $("#subscriber-mur-name").autocomplete({
                        source: mskNames,
                        focus: function(event, ui) {
                            event.preventDefault();
                            $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                            event.preventDefault();
                            $(this).val(ui.item.label);
                            $('#subscriber-mur-office').val(ui.item.value);
                            var text = $('#subscriber-mur-office').find("option:selected").text();
                            $('#vks_subscriber_mur_office_text').val(text);              // т.к. событие всавки, а не изменения
                        }
                    });
                });
            },
            error: function (data) {
                console.log('error occure');
            }
        });
    });

    $(document).ready(function () {
        $.ajax({
            type: 'get',
            url: '/vks/sessions/subscribers-msk',
            autoFocus: true,
            success: function (data) {
                var mskNames = $.parseJSON(data);
                $(function() {
                    $("#subscriber-name").autocomplete({
                        source: mskNames,
                        focus: function(event, ui) {
                            event.preventDefault();
                            $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                            event.preventDefault();
                            $(this).val(ui.item.label);
                            $('#subscriber-office').val(ui.item.value);
                            var text = $('#subscriber-office').find("option:selected").text();
                            $('#vks_subscriber_office_text').val(text);              // т.к. событие всавки, а не изменения
                        }
                    });
                });
            },
            error: function (data) {
                console.log('error occure');
            }
        });
    });

    $(document).ready(function () {
        $('select').each(function () {
            var val = $(this).find("option:selected").text();
            if (val != 'Выберите') {
                var text = '_text';
                var id = '#' + $(this).data("name") + text;
                $(id).val(val);
            }
        });
        $('select').on('change', function (e) {
            var val = $(this).find("option:selected").text();
            var text = '_text';
            var id = '#' + $(this).data("name") + text;
            $(id).val(val);
        });
    });


</script>

