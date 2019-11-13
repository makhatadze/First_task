<?php

namespace app\models;

use app\models\questions\Questions;
use http\Client\Curl\User;
use Yii;

/**
 * This is the model class for table "log_answer".
 *
 * @property int $id
 * @property int $user_id
 * @property int $quiz_id
 * @property int $question_id
 * @property int $answer_id
 * @property int $answer_name
 *
 * @property Questions $question
 * @property Quiz $quiz
 * @property User $user
 */
class LogAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'quiz_id', 'question_id', 'answer_id',], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'quiz_id' => 'Quiz ID',
            'question_id' => 'Question ID',
            'answer_id' => 'Answer ID',
            'answer_name' => 'Answer Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
