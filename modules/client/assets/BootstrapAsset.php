<?php

/**
 * TopicAddAsset class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@dm/helpsystem/client/assets';
    public $css = [
    		'css/helpSystemClient_bootstrap.css'
    ];
    public $js = [
    		
    ];
    public $depends = [
     
    ];
}
