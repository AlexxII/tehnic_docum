<?php

namespace app\modules\tehdoc\asset;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{

  public $sourcePath = '@app/modules/tehdoc/';

  public $css = [
      'css/tehdoc.css'
  ];

  public $js = [

  ];

  public $depends = [
      'app\modules\tehdoc\asset\TableBaseAsset',
  ];

}
