<?php

use yii\helpers\Html;

$this->title = 'Журнал проведения сеансов видеосвязи';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = "Журнал";

$about = "Журнал проведения сеансов видеосвязи";

?>

<div class="admin-pannel">

    <h1><?= Html::encode($this->title) ?>
        <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
             data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
    </h1>

</div>
