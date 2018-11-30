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
    .fa {
        font-size: 18px;
    }
    .navbar-inverse .navbar-nav > .active > a {
        background-color: #0000aa;
    }
    .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus {
        background-color: #0000aa;
        color: white;
    }
    .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
        background-color: #0000aa;
        color: white;
    }
    .navbar-inverse .btn-link:hover, .navbar-inverse .btn-link:focus {
        text-decoration: none;
    }
    .navbar-nav > li > .dropdown-menu {
        background-color: #014993;
        color: white;
    }
    .dropdown-menu > li > a {
        color: white;
    }
    .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
        background-color: #05226f;
        color: white;
    }
    .dropdown-header {
        color: white;
    }
    a:hover{
        text-decoration: none;
    }

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
      'encodeLabels' => false,
      'items' => [
          ['label' => 'ТехДок', 'url' => ['/tehdoc']],
          ['label' => 'ВКС', 'url' => ['/vks']],
          ['label' => 'ТО', 'url' => ['/to']],
          ['label' => 'Админ панель', 'url' => ['/admin']],
          Yii::$app->user->isGuest ? (
          ['label' => 'Войти', 'url' => ['/site/login']]
          ) : ([
              'label' => '<i class="fa fa-user" aria-hidden="true" style="font-size: 18px"></i>',
              'items' => [
                  '<li class="dropdown-header" style="font-size: 10px">' . Yii::$app->user->identity->username . '</li>',
                  ['label' => '<i class="fa fa-cogs" aria-hidden="true" style="font-size: 16px"></i> Профиль',
                      'url' => ['/admin/user/profile']
                  ],
                  ['label' => ''
                      . Html::beginForm(['/site/logout'], 'post')
                      . Html::submitButton(
                          '<span style="cursor: default"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</span>',
                          [
                              'class' => 'btn btn-link logout',
                              'data-toggle' => "tooltip",
                              'data-placement' => "bottom",
                              'style' => [
                                  'padding' => '0px',
                              ]
                          ]
                      )
                      . Html::endForm()
                  ]
              ]
          ])
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