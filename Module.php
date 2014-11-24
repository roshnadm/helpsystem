<?php

/**
 * HelpSystem Module class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem;

use Yii;

class Module extends \yii\base\Module
{
	/**
	 * @property integer $bootstrapVersion
	 * @property string $userRole
	 * @property string $languageCode
	 */
	public $bootstrap        = 'off'; //Set default bootstrap version as 3
	public $userRole         = '';   // 'admin';//Set default user role as admin
	public $pageLayout       = null;
	public $languageCode     = 'en-us';	
	
	public function init()
	{   
		
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->controllerNamespace = 'dm\helpsystem\controllers';
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
