<?php

namespace dm\helpsystem\models;

use Yii;

/**
 * This is the model class for table "hlp_Section".
 *
 * @property integer $SectionId
 *
 * @property HlpSectionText[] $hlpSectionTexts
 * @property HlpTopic[] $hlpTopics
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hlp_Section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SectionId' => 'Section ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionTexts()
    {
        return $this->hasMany(SectionText::className(), ['SectionId' => 'SectionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['SectionId' => 'SectionId']);
    }
}
