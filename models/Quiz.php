<?php

namespace app\models;

use app\models\answer\Answer;
use app\models\questions\Questions;
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
 *  @property int $updated_by
 * @property int $created_by
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
            [['min_corect_answer', 'created_at', 'update_at', 'max_question','created_by','updated_by'], 'integer'],
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
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
        ];
    }
    public function delQuestion($param)
    {

        $question_id = (new \yii\db\Query())
            ->select(['id'])
            ->from('questions')
            ->where(['quiz_id' => $param])
            ->scalar();
        $answers = Answer::find()->where(['in','question_id',$question_id])->all();
        foreach ($answers as $answer){
            $answer->delete();
        }

        $questions = Questions::find()->where(['in','quiz_id',$param])->all();
         foreach ($questions as $question) {
             $question->delete();
         }


    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['quiz_id' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->select('username')->scalar();
    }
    public function getUpdatedby()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->select('username')->scalar();
    }
    function getSubject(){
        return $this->subject;
    }

}
