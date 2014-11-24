<?php
/** This is the CFormModel class
 * 
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 * 
 * The followings are the available attributes in CFormmodel TopicForm
 * @property integer $section
 * @property string $sectionText
 * @property string $title
 * @property integer $parent
 * @property string $body
 */

namespace dm\helpsystem\admin\models;

use Yii;
use yii\base\Model;

class TopicForm extends Model{
	public $section;
	public $sectionText;
	public $title;
	public $parent;
	public $body;
	

	/**
	 * @return array validation rules for CFormmodel attributes.
	 */
	public function rules(){
		return [
		    [['title'],'required'],
			[['title'], 'string','max'=>100],
			[['sectionText'],'string','max'=>100]		
			];
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */	
public function attributeLabels()
	{
		return [
			'section'    => 'Section',
			'title'      => 'Title',
			'parent'     => 'Parent',
			'body'       => 'Body',
		];
	}
	
}
