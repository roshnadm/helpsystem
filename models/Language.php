<?php

namespace dm\helpsystem\models;

use Yii;

/**
 * This is the model class for table "hlp_Language".
 *
 * @property string $LCID
 * @property string $Locale
 * @property string $LanguageCode
 *
 * @property HlpSectionText[] $hlpSectionTexts
 * @property HlpTopicText[] $hlpTopicTexts
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hlp_Language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LCID', 'Locale', 'LanguageCode'], 'required'],
            [['LCID'], 'string', 'max' => 5],
            [['Locale'], 'string', 'max' => 45],
            [['LanguageCode'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LCID' => 'Lcid',
            'Locale' => 'Locale',
            'LanguageCode' => 'Language Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionTexts()
    {
        return $this->hasMany(SectionText::className(), ['LCID' => 'LCID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicTexts()
    {
        return $this->hasMany(TopicText::className(), ['LCID' => 'LCID']);
    }
}
