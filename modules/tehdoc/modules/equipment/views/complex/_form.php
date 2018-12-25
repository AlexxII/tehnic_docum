<?php

// TODO Добавить checkbox - возвращаться в данную форму после сохранения.

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use \yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;


$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Элемент " + (index + 1))
    });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Элемент " + (index + 1))
    });
});
';
$this->registerJs($js);
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
</style>
<?php
$cat_hint = 'Обязательное! Необходима для классификации оборудования';
$title_hint = 'Обязательное! Укажите наименование комплекта';
$cat_hint = '1';
$date_hint = '2';
$place_hint = '3';
$quantity_hint = '4';


$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС. Сеанс ВКС из п.403 => ЗВС-ОГВ, ГФИ => КВС-ГФИ, Приемная Президента => КВС Приемной';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';

?>


<div class="col-lg-7 col-md-7" style="border-radius:2px;padding-top:10px">
    <div class="customer-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'dynamic-form']]); ?>
        <div class="form-group">
            <?php
            echo $form->field($modelComplex, 'category_id', [
                'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $cat_hint . '"></sup>{input}{hint}'
            ])->widget(\kartik\tree\TreeViewInput::class, [
                    'query' => \app\modules\admin\models\CategoryTbl::find()->addOrderBy('root, lft'),
                    'name' => 'category_kv',            // input name
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
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?= $form->field($modelComplex, 'complex_title', [
                        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
                    ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
                </div>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <?= $form->field($modelComplex, 'complex_serial')->textInput()->hint('Например: Windows XP SP3', ['class' => ' w3-label-under']); ?>
            </div>
        </div>

        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 15, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $models[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'break',
                'imageFiles',
            ],
        ]); ?>


        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-random"></i>
                <button type="button" class="pull-right add-item btn btn-success btn-xs">Добавить</button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->
                <?php foreach ($models
                               as $index => $model): ?>
                    <?php foreach ($fupload
                                   as $i => $file): ?>

                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-address"></span>
                                <button type="button" class="pull-right remove-item btn btn-danger btn-xs">Удалить
                                </button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                if (!$model->isNewRecord) {
                                    echo Html::activeHiddenInput($model, "[{$index}]id");
                                }
                                ?>
                                <div class="form-group">
                                    <div class="form-group col-md-5 col-lg-5">
                                        <?php
                                        echo $form->field($model, 'category_id', [
                                            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_type_hint . '"></sup>{input}{hint}'
                                        ])->dropDownList($model->vksPlacesList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите', 'options' => [
                                            'value' => 'none', 'disabled' => 'true', 'selected' => 'true'
                                        ]]])->hint('', ['class' => ' w3-label-under']);
                                        ?>
                                        <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
                                    </div>

                                    <div class="form-group col-md-7 col-lg-7">
                                        <?= $form->field($model, 'category_id', [
                                            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_place_hint . '"></sup>{input}{hint}'
                                        ])->dropDownList($model->vksPlacesList, ['data-name' => 'vks_place', 'prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('', ['class' => ' w3-label-under']);
                                        ?>
                                        <input name="VksSessions[vks_place_text]" id="vks_place_text" style="display: none">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($model, 'eq_title', [
                                        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
                                    ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
                                </div>
                                <div class="form-group">
                                    <div class="form-group col-md-6 col-lg-6">
                                        <?= $form->field($model, 'eq_manufact')->textInput(['id' => 'manufact'])->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <?= $form->field($model, 'eq_model')->textInput(['id' => 'models'])->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
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
                                            'url' => Url::toRoute(ArrayHelper::merge(['/tehdoc/kernel/tools/remove-image'], ['id' => $photo->id, '_csrf' => Html::csrfMetaTags()])),
                                            'key' => $photo->id
                                        ];
                                    }
                                } else {
                                    $previewImagesConfig = false;
                                    $allImages = false;
                                }
                                ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>