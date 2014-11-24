HelpSystem 2 module
--------------


Requirements
------------

* Tested with Yii 2
* ckeditor 4


Quickstart
----------

1.Installation 


a. Using composer     
	Run 
	
	php composer.phar require --prefer-dist yiisoft/yii2-helpsystem "*" 

b. Manual Installation

    Download yii2-helpsystem  in application yii root folder.
    
    Add the module details in extensions.php 
~~~php
			'dm/helpsystem' =>
				array (
						'name' => 'dm/yii2-helpsystem',
						'version' => '1.0.0.0',
						'alias' =>
						 array (
							'@dm/helpsystem'          => $vendorDir . '/dm/yii2-helpsystem',
							'@dm/helpsystem/admin'    => $vendorDir . '/dm/yii2-helpsystem/modules/admin',
							'@dm/helpsystem/client'   => $vendorDir . '/dm/yii2-helpsystem/modules/client',
							'@dm/helpsystem/dmeditor' => $vendorDir . '/dm/yii2-helpsystem/vendor/dmeditor',
						),
				),
			    
~~~


2.Add module to your application config:

~~~php
<?php
    // ...
    'modules'=>[
        // ...
       	'modules'=>[
                    'helpsystem' =>
			['class' => 'dm\helpsystem\Module',
					'modules' => ['admin' => [
							'class'=>'dm\helpsystem\admin\Module',
					],
							'client' =>  'dm\helpsystem\client\Module',
							'dmeditor' => [
									'class'             => 'dm\helpsystem\dmeditor\Module',
									'allowedImageSize'  => 2, // add the maximum upload size in MB. Enter int value.
									'imageUploadPath'   => 'images/EditorImages',// the path to which image uploaded.
									'allowedImageTypes' => ['gif', 'jpeg', 'jpg', 'png']
							]
					],
					'bootstrap' => 'off' // on/off : set 'on' to apply helpsystem bootstrap style
                                                             // set to on when the application is not using bootstrap style,
                                       'userRole'=> ['admin'] ,//Add roles if any. eg ['admin','editor']
				       'pageLayout'=>'//layout/main' // set the page layout path here
			]
	],
    ]
    // ...
~~~

3.Run mysql script:

	a. /yii2-helpsystem/database/1_DDL/1_helpSystem_base_script.sql

	b. /yii2-helpsystem/database/4_DML/1_hlp_Language_Insert_script.sql

4.Finally add Help widget to your view template:

~~~php


<?= dm\helpsystem\client\components\HelpWidgetHelpWidget::widget(
			
				[
						'title'=>'CLIENT DEMO', // help link title
						  'header'=>'Survey',
					      'wrapperClass'=>'', // the class added to the wrapper div if any
					      'linkClass'=>'', // class name if we wish to add any
					      'sectionId'=>1,	// section reference mandatory
					      'topicId'=>0, // If you wanted to load a specific topic in help box give its primary key
						  'headerBackGroundColor'=>'#EAE8E9',		
				]
			);
?>
~~~


