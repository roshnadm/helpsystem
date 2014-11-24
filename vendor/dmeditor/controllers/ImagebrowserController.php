<?php

/**
 * ImagebrowserController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\dmeditor\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ImagebrowserController extends Controller{
	
	public function actionBrowse(){
		$this->layout = "@dm/helpsystem/dmeditor/views/layouts/imageBrowse";
		return $this->render("browse");
	}
	
	public function actionBrowseresponse(){	
		$imageList = $this->getImageFiles();
		print Json::encode($imageList);
		Yii::$app->end();
	}
	
	/**
	 * function to get all images from the saved lication
	 * @return multitype:multitype:string unknown
	 */
	private function getImageFiles(){
		$dir_path = $this->module->imageUploadPath;
		$fileList = []; 
		if (is_dir($dir_path)) {
		    if ($dir_handler = opendir($dir_path)) {
		        while (($file = readdir($dir_handler)) !== false) {
		        	if(is_file($dir_path."/".$file)){
		            	$fileList[] = ["fileName"=>$file,"src"=>$dir_path."/".$file];
		        	}
		        }
		        closedir($dir_handler);
		    }
		}
		return $fileList;
	}
}