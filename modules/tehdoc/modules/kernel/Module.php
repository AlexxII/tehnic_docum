<?php

namespace app\modules\tehdoc\modules\kernel;

class Module extends \yii\base\Module
{

  public $defaultRoute = 'equipment';
  public $layout = 'kernel_layout.php';

  public function init()
  {
    parent::init();
  }
}