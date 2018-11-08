<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\modules\admin\models\Category;
use app\modules\admin\models\Tree;


$this->title = 'Тестирование Nested sets';
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Тестирование";
$cat_hint = 'Категории оборудования';

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }

  .fa {
    font-size: 15px;
  }

  ul.fancytree-container {
    font-size: 20px;
  }

  input {
    color: black;
  }

  #test ul {
    list-style: none;
  }

  #test li {
    border: dotted;
    border-width: 0 0 1px 1px ;
    list-style: none;
  }

  #test li div {
    width:100%;
    position: relative;
    top:1em;
    background: white;
    margin-left: 10px;
  }

</style>

<div class="admin-category-pannel">

  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>
</div>
<div class="row">


<!--

 <!-- -->--><?php
/*  echo \kartik\tree\TreeView::widget([
  // single query fetch to render the tree
  'query'             => Tree::find()->addOrderBy('root, lft'),
  'headingOptions'    => ['label' => 'Категории'],
  'isAdmin'           => true,                       // optional (toggle to enable admin mode)
  'displayValue'      => 1,                           // initial display value
  //'softDelete'      => true,                        // normally not needed to change
  'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
  ]);

*/



var_dump($model2);


/*  foreach ($mod as $m)
  {
    echo $m['name'];
    echo '<br>';
  }
  */?>




</div>
