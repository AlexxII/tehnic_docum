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
      'css/kv-tree.min.css',
      'css/kv-tree-input.min.css',
      'css/bootstrap-dialog-bs3.min.css',
      'css/activeform.min.css',
      'css/animate.min.css',
      'css/html5input.min.css',
      'css/kv-widgets.min.css',
      'css/site.css',
      'css/w3.css',

  ];

  public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

  public $js = [
      'js/jQuery_mini.js',
      'js/bootstrap-datepicker.min.js',
      'js/bootstrap-datepicker.ru.min.js',
      'js/activeform.min.js',
      'js/dialog.js',
      'js/moment-with-locales.min.js',
      'js/fotorama.js',
      'js/tether.min.js'
  ];

  public $js2Options = ['position' => \yii\web\View::POS_END];

  public $js2 = [
      'js/kv-tree.min.js',
      'js/bootstrap-dialog.js',
      'js/dialog-yii.min.js',
      'js/kv-widgets.min.js',
      'js/kv-tree-input.min.js',
  ];

  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
  ];
}
