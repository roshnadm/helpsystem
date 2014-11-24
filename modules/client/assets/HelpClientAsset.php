<?php

/**
 * HelpClientAsset class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelpClientAsset extends AssetBundle
{
    public $sourcePath = '@dm/helpsystem/client/assets';
    public $css = [
    		'css/core_helpSystem.css',
    		'css/jquery-ui.css',
    ];
    public $js = [
    		'js/jquery-ui.min.js',
    		'js/HelpSystem.ui.HelpBox.js',
    		'js/jquery.ui.touch-punch.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
