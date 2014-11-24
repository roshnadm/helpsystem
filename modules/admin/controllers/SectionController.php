<?php

/**
 * SectionController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\HttpException;

use dm\helpsystem\components\DMController;
use dm\helpsystem\models\Section;
use dm\helpsystem\models\SectionText;
use dm\helpsystem\admin\components\DataManagement;

class SectionController extends DMController{	
	
	/**
	 * function to initialise the controller
	 */
	public function init(){		
		// set page layout and page title
		$this->setLayout();
		$this->getView()->title = Yii::$app->name.' - '.'Section';		
		parent::init();
	}
		
	/** 
	 * function to attach behaviours
	 */
	public function behaviors(){
		return  [
				'access' => [
						'class' => AccessControl::className(),
		        		'ruleConfig' => [
					        				'class' =>
		        								 'dm\helpsystem\admin\components\AccessRule'
						        		],
						'rules' => [
									   [
										'allow' => true,
										'actions' => ['index','update','delete'],
										]
									]
						 ]
			];
	}
	
	/**
	 * List all section
	 */
	public function actionIndex(){
		$sectionModel     = new Section();
		$sectiontextModel = new SectionText() ;
		$sectionList      = $this->getSectionList();
		
		if(!empty(Yii::$app->request->isPost)){
			
			$form = Yii::$app->request->post("SectionText");
			if (DataManagement::createSection(
							$form['Name'],
							$sectionModel,
							$sectiontextModel
						)){
				return	$this->redirect(["index"]);
			}
		}

		return	$this->render(
				"index",
				[
					"sectionModel"     => $sectionModel,
					"sectiontextModel" => $sectiontextModel,
					"sectionList"      => $sectionList,
				]);
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be reload the page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$sectionModel     = $this->loadModel($id);
		$sectionTextModel = new SectionText();
		if ($sectionModel->sectionTexts){
			$sectionTextModel = SectionText::findOne(
											$sectionModel->sectionTexts[0]->SectionTextId
									);
		}
		$sectionList    = $this->getSectionList();
		
		if(Yii::$app->request->post()){
			$form = Yii::$app->request->post("SectionText");
			if(DataManagement::updateSection(
								$form['Name'],
								$sectionTextModel,
								$id
			  )){
				$this->redirect(["index"]);
			}
		}
		return $this->render(
				"index",
				[
					"sectionModel"     => $sectionModel,
					"sectiontextModel" => $sectionTextModel,
					"sectionList"      => $sectionList,
				]);
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be reload page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{  
		if(Yii::$app->request->isGet){			
			$sectionText = SectionText::deleteAll(
									[
										'SectionId'=>$id											
									]);
			$this->loadModel($id)->delete();
			$this->redirect(['index']);
		}

	}
	
	/**
	 * Returns the entire Section List as array
	 * @return SectionList array
	 */
	private function getSectionList(){
		$sectionList = Section::find()->all();
		return $sectionList;
	}
	
	/**
	 * set the layout for our controller
	 */
	private function setLayout(){
		$this->layout = Yii::$app->getModule('helpsystem')->pageLayout;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @throws CHttpException
	 * @return $model Object
	 */
	public function loadModel($id)
	{
		$model = Section::findOne($id);
		if($model===null){
			throw new HttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
}