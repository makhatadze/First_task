<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "quiz".
 *
 * @property int $id
 * @property string $subject
 * @property int $min_corect_answer
 * @property int $created_at
 * @property int $update_at
 * @property int $max_question
 *
 * @property Questions[] $questions
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' =>[
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','update_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['update_at']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_corect_answer', 'created_at', 'update_at', 'max_question'], 'integer'],
            [['subject'], 'string', 'max' => 127],
            [['subject','min_corect_answer','max_question'],'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'min_corect_answer' => 'Min Corect Answer',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'max_question' => 'Max Question',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['quiz_id' => 'id']);
    }
}
