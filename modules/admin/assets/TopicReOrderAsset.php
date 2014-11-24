<?php

/** TopicReOrderAsset class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\assets;

use yii\web\AssetBundle;

class TopicReOrderAsset extends AssetBundle
{
    public $sourcePath = '@dm/helpsystem/admin/assets';
    public $css = [
    		
    ];
    public $js = [
    		'js/jquery.jstree.js',
    		'js/topic.treeview.js'
    		
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
