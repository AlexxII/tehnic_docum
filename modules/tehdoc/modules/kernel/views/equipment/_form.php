<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use app\modules\tehdoc\modules\kernel\models\Equipment;


// TODO Добавить checkbox - возвращаться в данную форму после сохранения.


?>


<style>
    .fa {
        font-size: 15px;
        /*color: #1e6887;*/
        color: #FF0000;
    }

    .nonreq {
        color: #1e6887;
    }

    .select-selected {
        padding-left: 40px;
    }
</style>

<?php $cat_hint = 'Обязательное! Необходима для классификации оборудования.';
$title_hint = 'Обязательное! Необходимо для отображения в таблице.';
$place_hint = 'Обязательное! Укажите точное размещение оборудования. На эти данные будут опираться другие таблицы.';
$date_hint = 'Если не известен месяц, выберите январь известного года.';
$quantity_hint = 'Внимание! Указывайте отличную от 1 цифру 
ТОЛЬКО для идентичного оборудования и расходных материалов. Например: офисная бумага, батарейки. Будьте ВНИМАТЕЛЬНЫ, не вводите себя в заблуждение.'; ?>

<div class="col-lg-7 col-md-7" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>
    <div class="form-group">
        <?php
        /*    echo $form->field($model, 'category_id', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                        data-toggle="tooltip" data-placement="right" title="' . $cat_hint . '"></sup>{input}{hint}'
            ])->dropDownList(\app\modules\admin\models\Category::testTree(), ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('Выберите из списка', ['class' => ' w3-label-under']);
        */
        echo $form->field($model, 'category_id', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $cat_hint . '"></sup>{input}{hint}'
        ])->widget(\kartik\tree\TreeViewInput::class, [
                'query' => \app\modules\admin\models\CategoryTbl::find()->addOrderBy('root, lft'),
                'name' => 'category_kv',    // input name
                'asDropdown' => true,            // will render the tree input widget as a dropdown.
                'multiple' => false,            // set to false if you do not need multiple selection
                'fontAwesome' => true,            // render font awesome icons
                'rootOptions' => [
                    'label' => '<i class="fa fa-tree"></i>',
                ]
            ]
        )->hint('Выберите из списка', ['class' => ' w3-label-under']);
        ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'eq_title', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
        ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
    </div>
    <div class="form-group">
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'eq_manufact')->textInput()->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'eq_model')->textInput()->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'eq_serial')->textInput()->hint('Например: MTC3T32231', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?= $form->field($model, 'eq_factdate', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
            ])->textInput([
                'class' => 'fact-date form-control'
            ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group col-md-8">

            <?= $form->field($model, 'place_id', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $place_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\PlacementTbl::find()->addOrderBy('root, lft'),
                    'name' => 'placement_kv',    // input name
                    'asDropdown' => true,            // will render the tree input widget as a dropdown.
                    'multiple' => false,            // set to false if you do not need multiple selection
                    'fontAwesome' => true,            // render font awesome icons
                    'rootOptions' => [
                        'label' => '<i class="fa fa-tree"></i>',
                    ]
                ]
            )->hint('Выберите из списка', ['class' => ' w3-label-under']);
            ?>
        </div>
        <div class="form-group col-md-4">
            <?= $form->field($model, 'quantity', [
                'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'
            ])->textInput()->hint('Введите количество', ['class' => ' w3-label-under']); ?>
        </div>
    </div>

    <?php
    if (!empty($model->photos)) {
        foreach ($model->photos as $k => $photo) {
            $allImages[] = "<img src='" . $photo->getImageUrl() . "' class='file-preview-image' style='max-width:100%;max-height:100%'>";
            $previewImagesConfig[] = [
                'url' => Url::toRoute(ArrayHelper::merge(['/tehdoc/kernel/equipment/remove-image'], ['id' => $photo->id, '_csrf' => Html::csrfMetaTags()])),
                'key' => $photo->id
            ];
        }
    } else {
        $previewImagesConfig = false;
        $allImages = false;
    }
    ?>

    <div class="form-group">
        <?= $form->field($fUpload, "imageFiles[]")->widget(FileInput::class, [
            'language' => 'ru',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'previewFileType' => 'any',
                'initialPreview' => $allImages,
                'initialPreviewConfig' => $previewImagesConfig,
                'overwriteInitial' => false,
                'showUpload' => false
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <label style="font-size:18px"><input type="checkbox" name="stay" style="width:20px;height:20px"> Остаться в форме</label>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $(document).ready(function () {
        $('.fact-date').datepicker({
            format: 'MM yyyy г.',
            autoclose: true,
            language: "ru",
            startView: "months",
            minViewMode: "months",
            clearBtn: true
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

    $(document).ready(function () {
        $("#equipment-category_id option").each(function () {
            a = document.createElement("DIV");
            b = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.appendChild(b);
            b.textContent = '';
            $(b).css({
                color: "red"
            });
            this.appendChild(a);
        });
    });


</script>

