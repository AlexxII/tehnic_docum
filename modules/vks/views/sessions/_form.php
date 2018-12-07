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

\app\modules\vks\assets\MaskedInputAsset::register($this);

$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС. Сеанс ВКС из п.403 => ЗВС-ОГВ, ГФИ => КВС-ГФИ, Приемная Президента => КВС Приемной';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';
$vks_subscrof_hint = 'Укажите ';
$vks_subscr_hint = 'Укажите ';
$vks_order_hint = 'Обязательное поле! Укажите ';
$vks_recmsg_subscr_hint = 'Обязательное поле! Укажите ФИО сотрудника, принявшего сообщение о предстоящем сеансе ВКС';
$vks_recmsg_date_hint = 'Обязательное поле! Укажите дату получения сообщения о предстоящем сеансе ВКС';
$vks_employee_send_hint = 'Обязательное поле! Укажите ФИО сотрудника, передавшего сообщение о предстоящем сеансе ВКС';
$vks_employee_hint = 'Обязательное поле! Укажите ';
?>

<div>
    <div class="col-lg-7 col-md-7" style="border-radius:2px;padding-top:10px">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>

        <div class="form-group">
            <div class="form-group col-md-7 col-lg-7">
                <?= $form->field($model, 'vks_date', [
                    'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_date_hint . '"></sup>{input}{hint}'
                ])->textInput([
                    'class' => 'vks-date form-control'
                ])->hint('', ['class' => ' w3-label-under']); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group col-md-7 col-lg-7">
                <?= $form->field($model, 'vks_teh_time_start')->textInput(['class' => 'time-mask form-control'])->hint('', ['class' => ' w3-label-under']); ?>
            </div>
            <div class="form-group col-md-6 col-lg-6">
            </div>
        </div>

        <div class="form-group">
            <div class="form-group col-md-7 col-lg-7">
                <?= $form->field($model, 'vks_work_time_start')->textInput(['class' => 'time-mask form-control'])->hint(' ', ['class' => ' w3-label-under']); ?>
            </div>
            <div class="form-group col-md-6 col-lg-6">
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
                    'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
                ])->dropDownList($model->vksSubscribesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
                ?>
            </div>
            <div class="form-group col-md-5 col-lg-5">
                <?= $form->field($model, 'vks_subscriber_name', [
                    'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscr_hint . '"></sup>{input}'
                ])->textInput()->hint('', ['class' => ' w3-label-under']); ?>
            </div>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?= $form->field($model, 'vks_order', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_order_hint . '"></sup>{input}{hint}'
            ])->dropDownList($model->vksOrdersList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
            ?>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?= $form->field($model, 'vks_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '5')) ?>
        </div>
    </div>
    <div class="col-lg-5 col-md-5"
         style="border-radius:4px;padding-top:10px;padding-bottom: 10px; margin-bottom: 15px;border: dashed 1px">
        <h3>Служебное</h3>
        <div class="form-group col-md-12 col-lg-12">
            <?php
            echo $form->field($model, 'vks_employee_receive_msg')->textInput()->hint('', ['class' => ' w3-label-under']);
            ?>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?= $form->field($model, 'vks_receive_msg_datetime', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_recmsg_date_hint . '"></sup>{input}{hint}'
            ])->textInput([
                'class' => 'vks_receive-date form-control'
            ])->hint('', ['class' => ' w3-label-under']); ?>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?= $form->field($model, 'vks_employee_send_msg', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_send_hint . '"></sup>{input}{hint}'
            ])->dropDownList($model->vksEmployeesList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
            ?>
        </div>
    </div>
</div>
<div class="form-group col-md-12 col-lg-12">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
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
                        var val = $(this).val().split(':');
                        if (val[0] * 1 > 23) val[0] = '23';
                        if (val[1] * 1 > 59) val[1] = '59';
                        $(this).val(val.join(':'));
                        $('.time-mask').focus();
                    }
                }
            );
        })
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#w1-tree-input-menu').on('change', function (e) {
            var text = $('#w1-tree-input').text();
            $('#equipment-eq_title').val(text);
        });
    });

    $(document).ready(function () {
        $('.vks-date').datepicker({
            format: 'd MM yyyy г.',
            autoclose: true,
            language: "ru",
            startView: "days",
            minViewMode: "days",
            clearBtn: true,
            todayHighlight: true,
            daysOfWeekHighlighted: [0, 6]
        })
    });

    $(document).ready(function () {
        $('.vks_receive-date').datepicker({
            format: 'd MM yyyy г.',
            autoclose: true,
            language: "ru",
            startView: "days",
            minViewMode: "days",
            clearBtn: true,
            todayHighlight: true,
            daysOfWeekHighlighted: [0, 6]
        })
    });

    $(document).ready(function () {
        if ($('.vks-date').val()) {
            var date = new Date($('.vks-date').val());
            moment.locale('ru');
            $('.vks-date').datepicker('update', moment(date).format('MMMM YYYY'))
        }
    });

    $(document).ready(function () {
        $('.vks_receive-date').datepicker("update", new Date());
    });

    //преобразование дат перед отправкой
    $(document).ready(function () {
        $('#w0').submit(function () {
            var d = $('.vks-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.vks-date').val(d);
        });
    });

</script>

