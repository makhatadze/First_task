<?php

namespace app\models;

use app\models\answer\Answer;
use app\models\questions\Questions;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
 * @property int $updated_by
 * @property int $created_by
 * @property int $certificate_valid_time
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

            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'update_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at']
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
            [['certificate_valid_time', 'min_corect_answer', 'max_question', 'created_by', 'updated_by'], 'integer'],
            [['subject'], 'string', 'max' => 127],
            [['subject', 'min_corect_answer', 'max_question'], 'required'],
            [['subject'], 'unique'],
            ['max_question', 'compare', 'compareAttribute' => 'min_corect_answer', 'operator' => '>=', 'type' => 'number'],
            [['min_corect_answer', 'max_question'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number'],
            ['max_question', 'compare', 'compareValue' => $this->count(), 'operator' => '>=', 'type' => 'number'],
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
            'certificate_valid_time' => 'Certificate Time',
        ];
    }

    public function count()
    {
        $count = Questions::find()
            ->where(['quiz_id' => $this->id])
            ->count();
        return $count;
    }


    public function deleteQuestion($param)
    {

        $question_id = (new \yii\db\Query())
            ->select(['id'])
            ->from('questions')
            ->where(['quiz_id' => $param])
            ->scalar();
        Answer::deleteAll(['question_id' => $question_id]);
        Questions::deleteAll(['quiz_id' => $param]);

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

    function getSubject()
    {
        return $this->subject;
    }

    function questionValidate()
    {
        $questionCount = $this->hasMany(Questions::className(), ['quiz_id' => 'id'])->count();
        if ($questionCount == 0) {
            return false;
        }
        return true;
    }

    function answerValidate($id)
    {
        $questions = Questions::find()->where(['in', 'quiz_id', $id])->all();
        $validate = true;
        foreach ($questions as $question) {
            if (!$question->answers) {
                $validate = false;
            } else {
                $validate = true;
            }
        }
        return $validate;
    }

    function correctValidate()
    {

    }

}
