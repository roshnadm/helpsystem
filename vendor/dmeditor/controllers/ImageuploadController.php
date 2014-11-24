<?php

/**
 * ImageuploadController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\dmeditor\controllers;

use Yii;
use yii\web\Controller;

class ImageuploadController extends Controller{
	
	public function actionUpload(){
		
		$CKEcallback = Yii::$app->request->get('CKEditorFuncNum');
		$type =Yii::$app->request->get('Type');
		$type = (($type)?Yii::$type:'File');
		
		//pass it on to file upload function
		$this->FileUpload( $type, $CKEcallback );

	}
	
	/**
	 * upload the file after validation
	 * @param string $sType
	 * @param string $CKEcallback
	 */
	private function FileUpload( $sType, $CKEcallback ){
		$request = Yii::$app->request;
		$sErrorNumber = 0;
		if($request->isPost){
				
			$image = $_FILES['upload'];
				
			if($image){
				$uploadedFile = $image['name'];
				$allowedSize = $this->module->allowedImageSize * pow(1024, 2);
				$size = $image['size'];
				$uploadedFile = $this->NewFileName($uploadedFile);
				$extension = substr( $uploadedFile, ( strrpos($uploadedFile, '.') + 1 ) ) ;
				$extension = strtolower( $extension ) ;
				if($uploadedFile){
					$uploadPath = $this->module->imageUploadPath;	
					if(!is_dir($uploadPath))
					{
						mkdir($uploadPath, 0777);
						chmod($uploadPath, 0777);
					}
					$filePath = $uploadPath.'/'.$uploadedFile;
					if($this->validImageUpload($extension)){
						if($allowedSize < $size || $size==0){
							$filePath="";
							$uploadedFile="";
							
							$sErrorNumber = 201;
						}else{
							move_uploaded_file( $image['tmp_name'], $filePath ) ;
						}
					
					}else{
						$filePath="";
						$uploadedFile="";
						$sErrorNumber = 202;
					}
						//issue the CKEditor Callback
						$this->SendCKEditorResults ($sErrorNumber, $CKEcallback, $filePath, $uploadedFile);
					}
					Yii::$app->end();
				}
			}
		}
		
	/**
	 * validate uploaded file extension
	 * @param string $extension
	 * @return boolean
	 */
	private function validImageUpload($extension){
		$imageCheckExtensions = $this->module->allowedImageTypes;
		if(in_array($extension, $imageCheckExtensions)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * cleanup of the file name to avoid possible problems
	 * @param string $fileName
	 * @return string $fileName
	 */
	private function NewFileName( $fileName )
	{
		$fileName = stripslashes( $fileName ) ;
		// Remove \ / | : ? * " < >
		$fileName = preg_replace( '/\\\\|\\/|\\||\\:|\\?|\\*|"|<|>|[[:cntrl:]]/', '_', $fileName ) ;
		$uniqueNum =  uniqid();
		$fileName = $uniqueNum.$fileName;
		return $fileName ;
	}
	
	/**
	 * This is the function that sends the results of the uploading process to CKEditor.
	 * @param INT $errorNumber
	 * @param string $CKECallback
	 * @param string $fileUrl
	 * @param string $fileName
	 * @param string $customMsg
	 */
	private function SendCKEditorResults ($errorNumber, $CKECallback='', $fileUrl, $fileName, $customMsg ='')
	{
		if ($errorNumber && $errorNumber != 201) {
			$fileUrl = "";
			$fileName= "";
		}
	
		$msg = "";
	
		switch ($errorNumber )
		{
			case 0 :
				$msg = "";
				break;
			case 1 :	// Custom error.
				$msg = $customMsg;
				break ;
			case 201 :
				$msg = 'The uploaded file size is above 2MB. Please upload small size images' ;
				break ;
			case 202 :
				$msg = 'Invalid file' ;
				break ;
			default :
				$msg = 'Error on file upload. Error number: ' + $errorNumber ;
				break ;
		}
		$rpl =['\\' => '\\\\', '"' => '\\"' ] ;		
	    echo 
		'<script type="text/javascript">';
		echo 'window.parent.CKEDITOR.tools.callFunction("'. $CKECallback. '","'. strtr($fileUrl, $rpl). '", "'. strtr( $msg, $rpl). '");' ;
	
		echo '</script>';
	}
}