<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;
use \yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\tehdoc\asset\TehFormAsset;

?>

<style>
  .req {
    font-size: 15px;
    color: #FF0000;
  }
  .nonreq {
    font-size: 15px;
    color: #1e6887;
  }
  .select-selected {
    padding-left: 40px;
  }
  .form-group {
    margin-bottom: 5px;
  }
</style>

<?php
TehFormAsset::register($this);

$cat_hint = 'Обязательное! Укажите категорию комплекта.';
$title_hint = 'Обязательное! Укажите наименование комплекта.';
$serial_hint = 'Укажите серийный номер (s/n), на некоторых моделях оборудования указывается только производственный номер (p/n), 
                  тогда укажите его.';
$manufact_hint = '';
$model_hint = '';

$date_hint = 'Если не известен месяц, выберите январь известного года.';
$place_hint = 'Обязательное! Укажите точное размещение оборудования.';
$quantity_hint = 'Внимание! Указывайте отличную от 1.php цифру 
ТОЛЬКО для идентичного оборудования и расходных материалов. Например: офисная бумага, батарейки.';

$eq_cat_hint = 'Обязательное! Необходима для классификации оборудования.';
$eq_title_hint = 'Обязательное! Необходимо для отображения в таблице.';
?>


<div class="row">
  <div class="col-lg-8 col-md-9">
    <div class="customer-form">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'dynamic-form']]); ?>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?php
          echo $form->field($modelComplex, 'category_id', [
            'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $cat_hint . '"></sup>{input}{hint}'
          ])->dropDownList($modelComplex->toolCategoryList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('Выберите категорию', ['class' => ' w3-label-under']);
          ?>
        </div>
        <div class="col-md-6 col-lg-6">
          <?= $form->field($modelComplex, 'complex_title', [
            'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
          ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?= $form->field($modelComplex, 'complex_manufact', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $manufact_hint . '"></sup>{input}{hint}'
          ])->textInput(['id' => 'manufact'])->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="col-md-6 col-lg-6">
          <?= $form->field($modelComplex, 'complex_model', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $model_hint . '"></sup>{input}{hint}'
          ])->textInput(['id' => 'models'])->hint('Например: Probook 450', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?= $form->field($modelComplex, 'complex_serial', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $serial_hint . '"></sup>{input}{hint}'
          ])->textInput()->hint('Например: HRUEO139UI92', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="col-md-6 col-lg-6">
          <?= $form->field($modelComplex, 'complex_factdate', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
          ])->textInput(['class' => 'fact-date form-control'
          ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-8">
          <?php
          echo $form->field($modelComplex, 'place_id', [
            'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $place_hint . '"></sup>{input}{hint}'
          ])->dropDownList($modelComplex->toolPlacesList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('Выберите место нахождения оборудования', ['class' => ' w3-label-under']);
          ?>
        </div>
        <div class="form-group col-md-4">
          <?= $form->field($modelComplex, 'quantity', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'
          ])->textInput()->hint('Введите количество', ['class' => ' w3-label-under']); ?>
        </div>
      </div>

      <div class="padding-v-md">
        <div class="line line-dashed"></div>
      </div>

      <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 6, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsTool[0],
        'formId' => 'dynamic-form',
        'formFields' => [
          'category_id',
          'eq_title',
          'eq_manufact',
          'eq_model',
          'eq_serial',
          'eq_factdate',
          'place_id',
          'quantity',
          'imageFiles'
        ],
      ]); ?>

      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-random"></i>
          <button type="button" class="pull-right add-item btn btn-success btn-xs">Добавить</button>
          <div class="clearfix"></div>
        </div>

        <div class="panel-body container-items"><!-- widgetContainer -->

          <?php foreach ($modelsTool as $index => $model): ?>
            <?php foreach ($fupload as $i => $file): ?>

              <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                  <span class="panel-title-address"></span>
                  <button type="button" class="pull-right remove-item btn btn-danger btn-xs">Удалить</button>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                  <?php
                  // necessary for update action.
                  if (!$model->isNewRecord) {
                    echo Html::activeHiddenInput($model, "[{$index}]id");
                  }
                  ?>
                  <?php
                  echo $form->field($model, "[{$index}]category_id", [
                    'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $eq_cat_hint . '"></sup>{input}{hint}'
                  ])->dropDownList($model->toolCategoryList, ['data-name' => 'vks_type', 'class' => 'form-control category',
                    'prompt' => ['text' => 'Выберите',
                      'options' => [
                        'value' => 'none',
                        'disabled' => 'true',
                        'selected' => 'true'
                      ]]])->hint('Выберите категорию', ['class' => ' w3-label-under']); ?>
                  <?= $form->field($model, "[{$index}]eq_title")->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>

                  <div class="row">
                    <div class="col-sm-6">
                      <?= $form->field($model, "[{$index}]eq_manufact")->textInput()->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
                    </div>
                    <div class="col-sm-6">
                      <?= $form->field($model, "[{$index}]eq_model")->textInput()->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
                    </div>
                  </div><!-- end:row -->
                  <div class="row">
                    <div class="col-sm-6">
                      <?= $form->field($model, "[{$index}]eq_serial")->textInput()->hint('Например: MTC3T32231', ['class' => ' w3-label-under']); ?>
                    </div>
                    <div class="col-sm-6">
                      <?= $form->field($model, "[{$index}]eq_factdate")->textInput()->hint('Введите дату. Например 01.01.2003', ['class' => ' w3-label-under']); ?>
                    </div>
                  </div><!-- end:row -->
                  <div class="row">
                    <div class="col-md-8">
                      <?php
                      echo $form->field($model, "[{$index}]place_id", [
                        'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $place_hint . '"></sup>{input}{hint}'
                      ])->dropDownList($model->toolPlacesList, ['data-name' => 'vks_type', 'class' => 'form-control placement',
                        'prompt' => ['text' => 'Выберите',
                          'options' => [
                            'value' => 'none',
                            'disabled' => 'true',
                            'selected' => 'true'
                          ]]])->hint('Выберите место нахождения оборудования', ['class' => ' w3-label-under']);
                      ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($model, "[{$index}]quantity", [
                        'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'
                      ])->textInput(['class' => 'form-control quantity-input'])->hint('Введите количество',
                        ['class' => ' w3-label-under']); ?>
                    </div>
                  </div>

                  <?php
                  if (!empty($model->photos)) {
                    $allimages = null;
                    $previewImagesConfig = null;
                    foreach ($model->photos as $photo) {
                      $allimages[$index][] = "<img src='" . $photo->getImageUrl() . "' class='file-preview-image' style='max-width:100%;max-height:100%'>";
                      $previewImagesConfig[$index][] = [
                        'url' => Url::toRoute(ArrayHelper::merge(['/site/delete-image'], ['id' => $photo->id])),
                        'key' => $photo->id
                      ];
                    }
                    echo $form->field($file, "[{$index}]imageFiles[]")->widget(FileInput::class, [
                      'language' => 'ru',
                      'options' => ['multiple' => true],
                      'pluginOptions' => [
                        'previewFileType' => 'any',
                        'initialPreview' => $allimages[$index],
                        'initialPreviewConfig' => $previewImagesConfig[$index],
                        'overwriteInitial' => false,
                        'showUpload' => false,
                        'showRemove' => false,
                        'uploadUrl' => Url::to(['/site/file-upload/'])
                      ]
                    ]);

                  } else {
                    $previewImagesConfig = false;
                    $allimages[$index] = false;
                    echo $form->field($file, "[{$index}]imageFiles[]")->widget(FileInput::class, [
                      'language' => 'ru',
                      'options' => ['multiple' => true],
                      'pluginOptions' => [
                        'previewFileType' => 'any',
                        'initialPreview' => $allimages[$index],
                        'initialPreviewConfig' => $previewImagesConfig[$index],
                        'overwriteInitial' => false,
                        'showUpload' => false,
                        'showRemove' => false,
                        'uploadUrl' => Url::to(['/site/file-upload/'])
                      ]
                    ]);
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
        <?= Html::submitButton($modelComplex->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>