<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
      'lib/awesome/css/font-awesome.min.css',
      'css/bootstrap-datepicker.min.css',
      'css/fotorama.css',
      'css/site.css',
      'css/w3.css',
  ];

  public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

  public $js = [
      'js/jQuery_mini.js',
      'js/bootstrap-datepicker.min.js',
      'js/bootstrap-datepicker.ru.min.js',
      'js/moment-with-locales.min.js',
      'js/fotorama.js',
      'js/tether.min.js'
  ];

  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
  ];
}
