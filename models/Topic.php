<?php

namespace dm\helpsystem\models;
use Yii;

/**
 * This is the model class for table "hlp_Topic".
 *
 * @property integer $TopicId
 * @property integer $ParentId
 * @property integer $SectionId
 * @property integer $Order
 * @property string $Created
 * @property string $Modified
 *
 * @property Topic $parent
 * @property Topic[] $topics
 * @property HlpSection $section
 * @property HlpTopicText[] $hlpTopicTexts
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hlp_Topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ParentId', 'SectionId', 'Order'], 'integer'],
            [['SectionId'], 'required'],
            [['Created', 'Modified'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TopicId' => 'Topic ID',
            'ParentId' => 'Parent ID',
            'SectionId' => 'Section ID',
            'Order' => 'Order',
            'Created' => 'Created',
            'Modified' => 'Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Topic::className(), ['TopicId' => 'ParentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['ParentId' => 'TopicId'])
                    ->orderBy('Order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['SectionId' => 'SectionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicTexts()
    {
        return $this->hasMany(TopicText::className(), ['TopicId' => 'TopicId']);
    }
}
