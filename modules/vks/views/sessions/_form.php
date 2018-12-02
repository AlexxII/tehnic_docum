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
$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС (Напрмер: ЗВС-ОГВ, КВС и т.д.)';
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
                <?= $form->field($model, 'vks_teh_time_start')->textInput()->hint('', ['class' => ' w3-label-under']); ?>
            </div>
            <div class="form-group col-md-6 col-lg-6">

            </div>
        </div>

        <div class="form-group">
            <div class="form-group col-md-7 col-lg-7">
                <?= $form->field($model, 'vks_work_time_start')->textInput()->hint(' ', ['class' => ' w3-label-under']); ?>
            </div>
            <div class="form-group col-md-6 col-lg-6">
            </div>
        </div>


        <div class="form-group col-md-12 col-lg-12">
            <?php
            echo $form->field($model, 'vks_type', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_type_hint . '"></sup>{input}{hint}{error}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\CategoryTbl::find()->addOrderBy('root, lft'),
                    'name' => 'vks_type',
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
            <?= $form->field($model, 'vks_place', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_place_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                    'name' => 'vks_place',
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

        <div class="form-group">
            <div class="form-group col-md-7 col-lg-7">
                <?= $form->field($model, 'vks_subscriber_office', [
                    'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
                ])->widget(\kartik\tree\TreeViewInput::class, [
                        'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                        'name' => 'vks_subscriber_office',
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
                data-toggle="tooltip" data-placement="top" title="' . $vks_order_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                    'name' => 'vks_order',
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
            <?= $form->field($model, 'vks_comments')->textArea(array('rows' => '4', 'resize' => 'none')) ?>
        </div>
    </div>
    <div class="col-lg-5 col-md-5" style="border-radius:4px;padding-top:10px;padding-bottom: 10px; margin-bottom: 15px;border: dashed 1px">
        <h3>Служебное</h3>
        <div class="form-group col-md-12 col-lg-12">
            <?php
            echo $form->field($model, 'vks_employee_receive_msg', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_recmsg_subscr_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\CategoryTbl::find()->addOrderBy('root, lft'),
                    'name' => 'vks_employee_receive_msg',
                    'asDropdown' => true,
                    'multiple' => false,
                    'fontAwesome' => true,
                    'rootOptions' => [
                        'label' => '<i class="fa fa-tree"></i>',
                    ]
                ]
            )->hint('Выберите из списка', ['class' => ' w3-label-under']);
            ?>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?= $form->field($model, 'vks_receive_msg_datetime', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_recmsg_date_hint . '"></sup>{input}{hint}'
            ])->textInput([
                'class' => 'vks_receive-date form-control'
            ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>
        </div>

        <div class="form-group col-md-12 col-lg-12">
            <?php
            echo $form->field($model, 'vks_employee_send_msg', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_send_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\CategoryTbl::find()->addOrderBy('root, lft'),
                    'name' => 'vks_employee_send_msg',
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
    </div>
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
        $('.vks-date').datepicker({
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
        $('.vks_receive-date').datepicker({
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

