<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\tehdoc\asset\Asset;

?>
<?php

AppAsset::register($this);    // регистрация ресурсов всего приложения
Asset::register($this);       // регистрация ресурсов модуля

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

  <style>
    .navbar-inverse .navbar-nav > .active > a {
      background-color: #05226f;
    }
    .navbar-inverse .navbar-nav > .active > a:hover {
      background-color: inherit;
    }

  </style>

</head>

<body>

<?php $this->beginBody() ?>

<div class="wrap">
  <?php
  NavBar::begin([
      'brandLabel' => '<img src="/images/logo.jpg" style="display:inline">',
      'brandUrl' => Yii::$app->homeUrl,
      'options' => [
          'class' => 'navbar-inverse',
      ],
  ]);
  echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => [
          ['label' => 'Категории', 'url' => ['/admin/category/index']],
          ['label' => 'Места размещения', 'url' => ['/admin/placement']],
          ['label' => 'Пользователи', 'url' => ['/admin/user/index']],
          ['label' => 'Классификаторы', 'url' => ['/admin/classifier/index']],
          Yii::$app->user->isGuest ? (
          ['label' => 'Войти', 'url' => ['/site/login']]
          ) : (
              '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
                  'Logout (' . Yii::$app->user->identity->username . ')',
                  ['class' => 'btn btn-link logout']
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
        'options' => [
            'class' => 'breadcrumb'
        ],
        'tag' => 'ol',

    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
  </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
