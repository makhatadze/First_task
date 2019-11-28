<?php

namespace app\models;

use app\models\answer\Answer;
use app\models\questions\Questions;
use http\Url;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property string $quiz_name
 * @property int $question_count
 * @property int $correct_answer
 * @property int $min_correct_answer
 * @property int $created_at
 * @property int $created_by
 * @property int $certificate_valid_time
 *
 *
 * @property Quiz $quiz
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $certificate_time;
    public $date;

    public static function tableName()
    {
        return 'result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_valid_time', 'correct_answer', 'created_by', 'min_correct_answer', 'question_count', 'created_at'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_name' => 'Quiz Name',
            'correct_answer' => 'Correct Answer',
            'min_correct_answer' => 'Min Correct Answer',
            'question_count' => 'question count',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'certificate_valid_time' => 'Certificate Time'

        ];
    }

    public function getUserName()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->select('username')->scalar();
    }

    public function dataJsonEncode($id)
    {
        $user = User::find()->all();
        $questions = Questions::find()
            ->asArray()
            ->where(['quiz_id' => $id])
            ->with(['answers', 'logAnswers'])
            ->select(['id', 'name', 'quiz_id'])
            ->all();
        return $questions;
    }

    public function createResult($data)
    {
        $quizId = (int)$data['quizID'];
        $quizName = Quiz::find()->where(['id' => $quizId])->select('subject')->scalar();
        $certificateTime = Quiz::find()->where(['id' => $quizId])->select('certificate_valid_time')->scalar();
        $minCorrect = Quiz::find()->where(['id' => $quizId])->select('min_correct_answer')->scalar();
        $userId = Yii::$app->user->id;

        $month = "+" . $certificateTime . " month";

        $this->created_at = time();
        $this->correct_answer = (int)$data['correctAnswer'];
        $this->question_count = (int)$data['questionCount'];
        $this->min_correct_answer = $minCorrect;
        $this->certificate_valid_time = $certificateTime;
        $this->quiz_name = $quizName;
        $this->created_by = $userId;
        if ($minCorrect <= (int)$data['correctAnswer']) {
            $this->certificate_valid_time = strtotime($month, $this->created_at);
        }
        if($this->save()){
            if(LogAnswer::deleteAll(['user_id' =>$userId]))
            return true;
        }
        return false;


    }
    public function finishTime($quizID){
        $logAnwers = LogAnswer::find()->asArray()->where(['quiz_id' => $quizID, 'user_id' => Yii::$app->user->id])->all();
        $correctAnswer = 0;
        $userId = Yii::$app->user->id;
        $minCorrect = Quiz::find()->where(['id' => $quizID])->select('min_correct_answer')->scalar();
        $quizName = Quiz::find()->where(['id' => $quizID])->select('subject')->scalar();
        $certificateTime = Quiz::find()->where(['id' => $quizID])->select('certificate_valid_time')->scalar();
        $month = "+" . $certificateTime . " month";
        $questionCount = Questions::find()->where(['quiz_id' => $quizID])->count();

        foreach ($logAnwers as $logAnwer) {
            if ($logAnwer["answer_id"]) {
                $correctAnswer += Answer::find()->where(['id' => $logAnwer["answer_id"]])->select('is_correct')->scalar();

            }
        }
        $this->created_by = $userId;
        $this->created_at = time();
        $this->correct_answer = $correctAnswer;
        $this->min_correct_answer = $minCorrect;
        $this->quiz_name = $quizName;
        $this->question_count = $questionCount;

        if ($minCorrect <= $correctAnswer) {
            $this->certificate_valid_time = strtotime($month, $this->created_at);
        }
        if ($this->save()) {
            if(LogAnswer::deleteAll(['user_id' => $userId]))
                return true;

        }
        return false;



    }


}
