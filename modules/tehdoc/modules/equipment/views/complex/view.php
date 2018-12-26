<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

$this->title = $modelComplex->complex_title;
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Оборудование', 'url' => ['/tehdoc/equipment/complex']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tool-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Изменить', ['update', 'id' => $modelComplex->id], ['class' => 'btn btn-primary btn-sm']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $modelComplex->id], [
      'class' => 'btn btn-danger btn-sm',
      'data' => [
        'confirm' => 'Вы уверены, что хотите удалить объект?',
        'method' => 'post',
      ],
    ]) ?>
  </p>


  <?= DetailView::widget([
    'model' => $modelComplex,
    'labelColOptions' => [
      'style' => 'width: 26.3%'
    ],
    'attributes' => [
      'id',
      'complex_title',
      [
        'label' => 'Категория',
        'value' => $modelComplex->category ? $modelComplex->category->cat_title : '-',
      ],
    ],
  ]) ?>

  <?php
  if (!empty($modelsTool)) {
    echo '<div class="w3-row">';
    echo '<h2>В состав АРМ входят:</h2>';
    foreach ($modelsTool as $modelTool) {
      echo '<div class="w3-col l7 m7 container">';
      echo DetailView::widget([
        'model' => $modelTool,
        'labelColOptions' => [
          'style' => 'width: 45%'
        ],
        'attributes' => [
          "eq_title",
          [
            'label' => 'Категория',
            'value' => $modelTool->category ? $modelTool->category->cat_title : '-',
          ],
          "eq_manufact",
          "eq_model",
          "eq_serial",
          [
            'label' => 'Место нахождения',
            'value' => $modelTool->place ? $modelTool->place->place_title : '-',
          ],
          [
            'label' => 'Изображения',
            'format' => 'raw',
            'value' => $modelTool->photos ? '<a href="#" style="color: #3f51b5">' . count($modelTool->photos) . ' штук(и)' . '</a>' : 'отсутствуют',
          ]
        ],
      ]);
      echo '</div>';
      echo '<div class="w3-col m5 l5 container w3-center">';
      if ($photos = $modelTool->photos) {
        $ph = null;
        foreach ($photos as $photo) {
          $ph[] = ['img' => $photo->getImageUrl()];
        }
        echo \metalguardian\fotorama\Fotorama::widget(
          [
            'items' => $ph,
            'options' => [
              'nav' => 'thumbs',
              'allowfullscreen' => true,
              'maxwidth' => '100%',
              'maxheight' => '350px',
            ]
          ]
        );
      }
      echo '<hr>';
      echo '</div>';
    }
    echo '</div>';
  }
  ?>
</div>