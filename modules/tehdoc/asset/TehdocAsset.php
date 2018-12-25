<?php

namespace app\modules\tehdoc\asset;

use yii\web\AssetBundle;

class TehdocAsset extends AssetBundle
{

  public $sourcePath = '@app/modules/tehdoc/lib';

  public $css = [
      'css/tehdoc.css',
      'css/bootstrap-datepicker.min.css',
  ];

  public $js = [
      'js/bootstrap-datepicker.min.js',
      'js/bootstrap-datepicker.ru.min.js',
      'js/moment-with-locales.min.js',
      'js/fotorama.js',
  ];

  public $depends = [
      'app\modules\tehdoc\asset\TableBaseAsset',
  ];

}
