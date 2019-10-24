<?php

namespace app\models;

use app\models\questions\Questions;
use Yii;
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


}
