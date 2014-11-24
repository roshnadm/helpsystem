<?php

/**
 * TopicAddAsset class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@dm/helpsystem/admin/assets';
    public $css = [
    		'css/helpSystemAdmin_bootstrap.css'
    ];
    public $js = [
    		
    ];
    public $depends = [
     	'dm\helpsystem\assets\HelpSystemAsset'
    ];
}
