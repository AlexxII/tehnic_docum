<?php

use yii\helpers\Html;


$this->title = 'Техническая документация';
$this->params['breadcrumbs'][] = $this->title;

$about = "Техническая документация";

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


echo 'Раздел находится в разработке';

$user = Yii::$app->user;
//var_dump(Yii::$app->authManager->getRolesByUser($user->getId()));
if(Yii::$app->user->can('military')){
  echo '<br>' . 'Только !';
}

  ?>
</div>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
