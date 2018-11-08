<?php

use yii\bootstrap\Nav;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

$this->title = 'Панель администрирования';
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель администрирования";

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
</style>

<div class="admin-pannel">

  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>

  <?php

  echo \wbraganca\fancytree\FancytreeWidget::widget([
      'options' => [
          'source' => [
              'url' => '/admin/user/test',
          ],
          'extensions' => ['dnd'],
          'dnd' => [
              'preventVoidMoves' => true,
              'preventRecursiveMoves' => true,
              'autoCollapse' => true,
              'dragStart' => new \yii\web\JsExpression('function(node, data) {
                    return true;
                }'),
              'dragEnter' => new \yii\web\JsExpression('function(node, data) {
                    return true;
                }'),
              'dragDrop' => new \yii\web\JsExpression('function(node, data) {
                    $.get("/admin/user/testt", {item: data.otherNode.key, action: data.hitMode, second:
                    node.key},function(){
                    data.otherNode.moveTo(node, data.hitMode);
                    })
                }'),
          ],
          'activate' => new \yii\web\JsExpression('function(node, data) {
                var node = data.node;
                if (node.data.url) {
                    window.location=(node.data.url);
                }
             }'),
          'renderNode' => new \yii\web\JsExpression('function(node, data) {
                 var node = data.node;
                 if(node.data.cstrender){
                    var $span = $(node.span);
                    $span
                        .find("> span.fancytree-icon")
                        .removeClass("fancytree-icon icon-file-alt")
                        .addClass(node.data.iconcustom);
                 }
            }'),
      ]
  ]); ?>

</div>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!--<div class="dropdown">
  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown trigger
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
    ...
  </ul>
</div>
-->
