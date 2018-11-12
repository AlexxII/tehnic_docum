<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$exit_hint = 'Выход ';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<style>
</style>


<body>
<?php $this->beginBody() ?>


<div class="wrap">
  <?php
  NavBar::begin([
      'brandLabel' => '<img src="/images/logo.jpg" style="display:inline ">',
      'brandUrl' => Yii::$app->homeUrl,
      'options' => [
          'class' => 'navbar-inverse navbar-fixed-top',
      ],
  ]);
  echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => [
          ['label' => 'ТехДок', 'url' => ['/tehdoc']],
          ['label' => 'ТО', 'url' => ['/to']],
          ['label' => 'Админка', 'url' => ['/admin']],
          Yii::$app->user->isGuest ? (
          ['label' => 'Войти', 'url' => ['/site/login']]
          ) : (
              '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
                  '<i class="fa fa-sign-out" aria-hidden="true" style="font-size: 18px"></i>',
                  [
                      'class' => 'btn btn-link logout',
                      'data-toggle' => "tooltip",
                      'data-placement' => "bottom",
                      'title' => $exit_hint . Yii::$app->user->identity->username,
                  ]
              )
              . Html::endForm()
              . '</li>'
          )
      ],
  ]);
  NavBar::end();
  ?>

  <div class="container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
  </div>
</div>

<footer class="footer">
  <div class="container">
  </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>