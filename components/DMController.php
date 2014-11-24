<?php
/**
 * DMController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */


namespace dm\helpsystem\components;

use Yii;
use yii\web\Controller;

/**
 * DMController is the customized base controller class.
 * All controller classes for this extension should extend from this base class.
 */
class DMController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/main',
	 * meaning using a single column layout. See 'app/views/layouts/main.php'.
	 */
	public $layout='@app/views/layouts/main';
}
