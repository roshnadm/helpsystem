<?php

namespace dm\helpsystem\models;

use Yii;

/**
 * This is the model class for table "hlp_SectionText".
 *
 * @property integer $SectionTextId
 * @property integer $SectionId
 * @property string $Name
 * @property string $LCID
 *
 * @property HlpLanguage $lC
 * @property HlpSection $section
 */
class SectionText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hlp_SectionText';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SectionId', 'Name', 'LCID'], 'required'],
            [['SectionId'], 'integer'],
            [['Name'], 'string', 'max' => 100],
            [['LCID'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SectionTextId' => 'Section Text ID',
            'SectionId' => 'Section ID',
            'Name' => 'Name',
            'LCID' => 'Lcid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLC()
    {
        return $this->hasOne(Language::className(), ['LCID' => 'LCID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['SectionId' => 'SectionId']);
    }
}
