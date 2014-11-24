<?php

/**
 * HelpWidget class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\components;

use Yii;
use yii\base\Widget;
use dm\helpsystem\client\assets\HelpClientAsset;
use dm\helpsystem\client\assets\BootstrapAsset;

/**
 * HelpWidget extends from Cwidget
 * This will return help link
 **/
class HelpWidget extends Widget{

	public $title        = "Help"; // default link title 
	public $header       = "Help";
	public $topicId      = 0; // If we need to load a specific topic
	public $sectionId    = 1; // current section 
	public $wrapperClass = ''; // out div class
	public $linkClass    = ''; // class for help link
	protected $assetsUrl; 
	public $headerBackGroundColor; // background color
	
	/**
	 *  main function
	 */
	public function run(){
		// load the view from views/helpLink
 		$this->registerAssestBundle();
		if($this->headerBackGroundColor)	{
			$this->registerHeaderBackgroundCSS($this->headerBackGroundColor);
		}	
		return $this->render(
				"helpLink",
				 [
			 		'title'         => $this->title,
			  		'wrapperClass'  => $this->wrapperClass,
			  		'linkClass'     => $this->linkClass,
			  		'topicId'       => $this->topicId,
			  		'sectionId'     => $this->sectionId,
			  		'header'        => $this->header,
			  		'assetUrl'      => $this->assetsUrl,
				  ]);
	}
	
	/**
	 * Update the header background color
	 */
	protected function registerHeaderBackgroundCSS($color)
	{
		$this->getView()->registerCss(" 
								.helphead{
											background:$color !important;
										  }
				                   "
								);
	}
	
	/**
	 * Registers the client JavaScript /css.
	 */
	protected function registerAssestBundle()
	{		
		$bundle          = HelpClientAsset::register(Yii::$app->getView());
		$this->assetsUrl = $bundle->baseUrl;
		if (Yii::$app->getModule('helpsystem')->bootstrap == "on"){
			BootstrapAsset::register(Yii::$app->getView());
		}
	}
}