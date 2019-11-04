<?php

namespace app\models\questions;

use app\models\answer\Answer;
use app\models\Quiz;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $name
 * @property string $hint
 * @property int $max_answers
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property Answer[] $answers
 * @property Quiz $quiz
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
                ],

            ],
        ];
    }

    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'max_answers', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'max_answers'], 'required'],
            [['name', 'hint'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            ['max_answers', 'compare', 'compareValue' => $this->countAnswer(), 'operator' => '>=', 'type' => 'number'],
            ['max_answers', 'compare', 'compareValue' => 1, 'operator' => '>', 'type' => 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Select quiz subject',
            'name' => 'Question title',
            'hint' => 'Hint',
            'max_answers' => 'Max Answers',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By'
        ];
    }

    public function countAnswer()
    {
        $count = Answer::find()
            ->where(['question_id' => $this->id])
            ->count();
        return $count;
    }

    public function maxQuestion($param)
    {
        $rows = Quiz::find()->where(['in', 'id', $param])->select('max_question')->scalar();
        $questions = Questions::find()->where(['in', 'quiz_id', $param])->count();
        if ($questions >= $rows) {
            return false;
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->select('username')->scalar();
    }

    public function getUpdatedby()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->select('username')->scalar();
    }
    public function questionStatus(){
        $answers = $this->hasMany(Answer::className(),['question_id' => 'id'])->all();
        $countAnswer = $this->hasMany(Answer::className(),['question_id' => 'id'])->count();
        $correct = 0;
        if($countAnswer <= 1){
            return false;
        }   else {
            foreach ($answers as $answer){
                $correct += $answer->is_correct;
            }
            if($correct == 0){
                return false;
            }
        }
        return true;
    }
}
