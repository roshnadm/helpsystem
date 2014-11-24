<?php

/**
 * AccessRules class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\components;

use Yii;

class AccessRule extends \yii\filters\AccessRule{
	/**
	 * Function checks for the access according to the user role(s) specified in the configuration.
	 * If no roles specified then access will be granted for all users
	 * @param array $user
	 * @return boolean
	 */
	
	protected function matchRole($user)
	{						
		$role = Yii::$app->getModule('helpsystem')->userRole;
        
        // if no rules , the access will be granted
		if (empty($role)) {
			return true;
		}  
		     
	    if (!$user->getIsGuest()) {	    	
			// user is not guest, let's check his role (or do something else)
			if(isset($user->identity->role)){
				if ($role === $user->identity->role) {
					return true;
				}
			}
		}	
		return false;
	}
}