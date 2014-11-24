<?php

/**
 * DMEditor Module class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\dmeditor;

use Yii;
use dm\helpsystem\dmeditor\assets\DMEditorAsset;

class Module extends  \yii\base\Module
{
	public $_editorAsset;
	public $allowedImageSize =2;
	public $imageUploadPath    = "images/EditorImages";
	public $allowedImageTypes  = ['gif', 'jpeg', 'jpg', 'png'] ;
	public $controllerNamespace = 'dm\helpsystem\dmeditor\controllers';

	public function init()
	{
		
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function getEditorAsset(){
		if($this->_editorAsset == null){
			$bundle = DMEditorAsset::register(Yii::$app->getView());
			$this->_editorAsset=$bundle->baseUrl;
		}
		return $this->_editorAsset;
	}
}
