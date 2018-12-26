<?php

// TODO Добавить checkbox - возвращаться в данную форму после сохранения.

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use \yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
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

$cat_hint = 'Обязательное! Укажите категорию оборудования для облегчения классификации и поиска';
$title_hint = 'Обязательное! Укажите наименование комплекта';
$date_hint = '2';
$place_hint = '3';
$quantity_hint = '4';

$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС. Сеанс ВКС из п.403 => ЗВС-ОГВ, ГФИ => КВС-ГФИ, 
                    Приемная Президента => КВС Приемной';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';

?>


<div class="col-lg-8 col-md-9" style="border-radius:2px;padding-top:10px">
  <div class="customer-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'dynamic-form']]); ?>
    <div class="form-group">
      <div class="form-group col-md-6 col-lg-6">
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
      <div class="form-group col-md-6 col-lg-6">
        <?= $form->field($modelComplex, 'complex_title', [
          'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
        ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
      </div>
    </div>
    <div class="form-group">
      <div class="form-group col-md-6 col-lg-6">
        <?= $form->field($modelComplex, 'complex_manufact', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
        ])->textInput(['id' => 'manufact'])->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="form-group col-md-6 col-lg-6">
        <?= $form->field($modelComplex, 'complex_model', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
        ])->textInput(['id' => 'models'])->hint('Например: Probook 450', ['class' => ' w3-label-under']); ?>
      </div>
    </div>
    <div class="form-group">
      <div class="form-group col-md-6 col-lg-6">
        <?= $form->field($modelComplex, 'complex_serial', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
        ])->textInput()->hint('Например: HRUEO139UI92', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="form-group col-md-6 col-lg-6">
        <?= $form->field($modelComplex, 'complex_factdate', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
        ])->textInput(['class' => 'fact-date form-control'
        ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>

      </div>
    </div>
    <div class="form-group">
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
    <div class="form-group">
      <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($modelComplex, 'complex_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '3')) ?>
      </div>
    </div>
    <div class="form-group col-md-12 col-lg-12">

      <div class="row"></div>
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
          'category_id'
        ],
      ]); ?>


      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-random"></i><strong> В составе</strong>
          <button type="button" class="pull-right add-item btn btn-success btn-xs">Добавить</button>
          <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
          <?php foreach ($models

          as $index => $model): ?>
          <?php foreach ($fUpload

          as $i => $file): ?>
          <div class="form-group col-md-12 col-lg-12">
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
                } ?>
                <div class="form-group">
                  <div class="form-group col-md-12 col-lg-12">
                    <?php
                    echo $form->field($model, "[{$index}]category_id", [
                      'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $cat_hint . '"></sup>{input}{hint}'
                    ])->dropDownList($model->toolCategoryList, ['data-name' => 'vks_type', 'class' => 'form-control category',
                      'prompt' => ['text' => 'Выберите',
                        'options' => [
                          'value' => 'none',
                          'disabled' => 'true',
                          'selected' => 'true'
                        ]]])->hint('Выберите категорию', ['class' => ' w3-label-under']); ?>
                  </div>
                  <div class="form-group col-md-12 col-lg-12">
                    <?= $form->field($model, "[{$index}]eq_title", [
                      'template' => '{label} <sup class="h-title fa fa-info-circle req" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'
                    ])->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
                  </div>
                  <div class="form-group">
                    <div class="form-group col-md-6 col-lg-6">
                      <?= $form->field($model, "[{$index}]eq_manufact")->textInput(['class' => 'form-control manufact'
                      ])->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
                    </div>
                    <div class="form-group col-md-6 col-lg-6">
                      <?= $form->field($model, "[{$index}]eq_model")->textInput(['class' => 'form-control models'
                      ])->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-group col-md-6 col-lg-6">
                      <?= $form->field($model, "[{$index}]eq_serial")->textInput()->hint('Например: MTC3T32231',
                        ['class' => ' w3-label-under']); ?>
                    </div>
                    <div class="form-group col-md-6 col-lg-6">
                      <?= $form->field($model, "[{$index}]eq_factdate", [
                        'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
                      ])->textInput([
                        'class' => 'fact-date form-control'
                      ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-group col-md-8">
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
                    <div class="form-group col-md-4">
                      <?= $form->field($model, "[{$index}]quantity", [
                        'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'
                      ])->textInput(['class' => 'form-control quantity-input'])->hint('Введите количество',
                        ['class' => ' w3-label-under']); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-group col-md-12 col-lg-12">

                      <?php
                      if (!empty($model->photos)) {
                        $allImages = null;
                        foreach ($model->photos as $photo) {
                          $allImages[$index][] = "<img src='" . $photo->getImageUrl() . "' class='file-preview-image' 
                          style='max-width:100%;max-height:100%'>";
                          $previewImagesConfig[$index][] = [
                            'url' => Url::toRoute(ArrayHelper::merge(['/site/delete-image'], ['id' => $photo->id])),
                            'key' => $photo->id
                          ];
                        }
                      } else {
                        $previewImagesConfig = false;
                        $allImages[$index] = false;
                      } ?>
                      <?= $form->field($file, "[{$index}]imageFiles[]")->widget(FileInput::class, [
                        'language' => 'ru',
                        'options' => ['multiple' => true],
                        'pluginOptions' => [
                          'previewFileType' => 'any',
                          'initialPreview' => $allImages[$index],
                          'initialPreviewConfig' => $previewImagesConfig[$index],
                          'overwriteInitial' => false,
                          'showUpload' => false,
                          'showRemove' => false,
                          'uploadUrl' => Url::to(['/site/file-upload/'])
                        ]
                      ]); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-group col-md-12 col-lg-12">
                      <?= $form->field($model, "[{$index}]eq_comments")->textArea(array('style' => 'resize:vertical',
                        'rows' => '2')) ?>
                    </div>
                  </div>

                </div>
              </div>
              <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php DynamicFormWidget::end(); ?>


      <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>
</div>


<script>

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.fact-date').datepicker({
      format: 'MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "months",
      minViewMode: "months",
      clearBtn: true
    });

    //преобразование дат перед отправкой
    $('#dynamic-form').submit(function () {
      var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-01');
      $('.fact-date').val(d);
    });

  });

  $(document).ready(function () {
    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('MMMM YYYY'))
    }
  });

  // функционал улучшения интерфецса формы

  var manufact, models;

  $(document).ready(function () {
    $.ajax({
      type: 'get',
      url: '/admin/interface/manufact',
      autoFocus: true,
      success: function (data) {
        manufact = $.parseJSON(data);
        $(function () {
          $("#manufact").autocomplete({
            source: manufact,
          });
        });
      },
      error: function (data) {
        console.log('Error loading Manufact list.');
      }
    });
  });

  $(document).ready(function () {
    $.ajax({
      type: 'get',
      url: '/admin/interface/models',
      autoFocus: true,
      success: function (data) {
        models = $.parseJSON(data);
        $(function () {
          $("#models").autocomplete({
            source: models,
          });
        });
      },
      error: function (data) {
        console.log('Error loading Models list');
      }
    });
  });

  $(".dynamicform_wrapper").on("afterInsert", function (e, item) {

    $(".dynamicform_wrapper .panel-title-address").each(function (index) {
      $(this).html("Элемент " + (index + 1))
    });

    $(item).find(".quantity-input").val('1');
    $(item).find(".category").val('none');
    $(item).find(".placement").val('none');

    $("[data-toggle='tooltip']").tooltip();

    $(".fact-date").datepicker({
      format: 'MM yyyy г.',
      autoclose: true,
      language: 'ru',
      startView: 'months',
      minViewMode: 'months',
      clearBtn: true
    });
    $(function () {
      $(".manufact").autocomplete({
        source: manufact,
      });
    });
    $(function () {
      $(".models").autocomplete({
        source: models,
      });
    });

  });

  $(".dynamicform_wrapper").on("afterDelete", function (e) {
    $(".dynamicform_wrapper .panel-title-address").each(function (index) {
      $(this).html('Элемент ' + (index + 1))
    });
  });


</script>
