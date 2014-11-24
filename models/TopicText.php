<?php

namespace dm\helpsystem\models;

use Yii;

/**
 * This is the model class for table "hlp_TopicText".
 *
 * @property integer $TopicTextId
 * @property integer $TopicId
 * @property string $Title
 * @property string $Body
 * @property string $Created
 * @property string $Modified
 * @property string $LCID
 *
 * @property HlpLanguage $lC
 * @property HlpTopic $topic
 */
class TopicText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hlp_TopicText';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TopicId', 'Title', 'LCID'], 'required'],
            [['TopicId'], 'integer'],
            [['Body'], 'string'],
            [['Created', 'Modified'], 'safe'],
            [['Title'], 'string', 'max' => 255],
            [['LCID'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TopicTextId' => 'Topic Text ID',
            'TopicId' => 'Topic ID',
            'Title' => 'Title',
            'Body' => 'Body',
            'Created' => 'Created',
            'Modified' => 'Modified',
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
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['TopicId' => 'TopicId']);
    }
}
