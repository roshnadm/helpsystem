<?php

/**
 * Client Module class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */


namespace dm\helpsystem\client;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'dm\helpsystem\client\controllers';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
	}


	public function beforeAction( $action)
	{
		if(parent::beforeAction($action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
