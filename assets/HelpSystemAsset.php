<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace dm\helpsystem\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelpSystemAsset extends AssetBundle
{
    public $sourcePath = '@dm/helpsystem/assets';
    public $css = [
        'css/core_helpSystemAdmin.css',
    ];
    public $js = [
    ];
}
