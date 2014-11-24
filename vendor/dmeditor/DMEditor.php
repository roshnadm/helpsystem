<?php 

/**
 * DMEditor class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\dmeditor;

use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use dm\helpsystem\dmeditor\assets\DMEditorAsset;

class DMEditor extends InputWidget{

	public $options = array();
	
	public function init()
	{
		
		$bundle =  DMEditorAsset::register($this->getView());
		Yii::$app->getModule('helpsystem')->getModule('dmeditor')->_editorAsset = $bundle->baseUrl;	
	    parent::init();
		
	}
	public function run(){

		if($this->hasModel()){
			echo Html::activeTextArea($this->model,$this->attribute,$this->options);
		}else{
			echo Html::textArea($this->name,$this->value,$this->options);
		}
		
		if (!isset($this->options['id'])) {
			$id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
		}else{
			$id = $this->options['id'];
		}
		
		$this->setOptions();
		$options=Json::encode($this->options);
		$this->registerEditorJs($id,$options);
	}

	private function registerEditorJs($id,$options){

		$js = "$( document ).ready( function() {
		    
			$('#{$id}').ckeditor({$options}); ";
		
		// ckeditor not including csrf token in the image upload form
		// force to inlude the csrf token input
		if(Yii::$app->request->enableCsrfValidation){
			$js .= " CKEDITOR.on('dialogDefinition', function (ev) {
				var dialogName = ev.data.name;
				var dialogDefinition = ev.data.definition;
				var csrf_token = jQuery('meta[name=csrf-token]').attr('content'),
				csrf_param = jQuery('meta[name=csrf-param]').attr('content')
			
			
				if (dialogName === 'image') {
					var uploadTab = dialogDefinition.getContents('Upload');
			
					for (var i = 0; i < uploadTab.elements.length; i++) {
						var el = uploadTab.elements[i];
			
						if (el.type !== 'fileButton') {
							continue;
						}
			
						// add onClick for submit button to add inputs or rewrite the URL
						var onClick = el.onclick;
						el.onClick = function(evt) {
							var dialog = this.getDialog();
							var fb = dialog.getContentElement(this['for'][0], this['for'][1]);
							var editor = dialog.getParentEditor();
             			    editor._.filebrowserSe = this;
							// if using jQuery
							$(fb.getInputElement().getParent().$).append('<input type=\"hidden\" name=\"'+csrf_param+'\" value=\"'+csrf_token+'\"/>');
							if (onClick && onClick.call(evt.sender, evt) === false) {
								return false;
							}
						};
					}
				}
			});";
		}
		$js .= " } );";
		$this->getView()->registerJs($js);
	}
	
	private function setOptions(){
		$this->options['filebrowserImageBrowseUrl'] = Url::to(["/helpsystem/dmeditor/imagebrowser/browse",
				"Type"=>"Image"]);
		$this->options['filebrowserUploadUrl']= Url::to(["/helpsystem/dmeditor/imageupload/upload"]);
		
	}
}
?>