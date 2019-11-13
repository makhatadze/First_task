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
 * @property int $min_correct_answer
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
            [['certificate_valid_time', 'min_correct_answer', 'max_question', 'created_by', 'updated_by'], 'integer'],
            [['subject'], 'string', 'max' => 127],
            [['subject', 'min_correct_answer', 'max_question'], 'required'],
            [['subject'], 'unique'],
            ['max_question', 'compare', 'compareAttribute' => 'min_correct_answer', 'operator' => '>=', 'type' => 'number'],
            [['min_correct_answer', 'max_question'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number'],
            ['max_question', 'compare', 'compareValue' => $this->countQuestion(), 'operator' => '>=', 'type' => 'number'],
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
            'min_correct_answer' => 'Min Correct Answer',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'max_question' => 'Max Question',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
            'certificate_valid_time' => 'Certificate Time',
        ];
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
    public function countQuestion()
    {
        $count = Questions::find()
            ->where(['quiz_id' => $this->id])
            ->count();
        return $count;
    }

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
            return [
                'success' => false,
                'message' => "Quiz have not question! "
            ];
        }
        return [
            'success' => true
        ];
    }

    function answerValidate($id)
    {
        $questions = Questions::find()->where(['in', 'quiz_id', $id])->all();

        foreach ($questions as $question) {
            if (!$question->questionStatus()) {
                return [
                    'success' => false,
                    'message' => "Some question answer is not complete! "
                ];
            }
        }

        return [
            'success' => true
        ];
    }

    function quizPassedValidate()
    {
        $questionCount = $this->hasMany(Questions::class, ['quiz_id' => 'id'])->count();

        if ($this->min_correct_answer > $questionCount) {
            return [
                'success' => false,
                'message' => "min correct answer more than questions! "
            ];
        }
        return [
            'success' => true
        ];
    }
    function logAnswer(){
        $userId = Yii::$app->user->id;
        return $this->hasMany(LogAnswer::className(), ['quiz_id' => 'id'])->andWhere(['user_id' => $userId]);
    }

    function generalValidate($id)
    {
        $questionValidation = $this->questionValidate();
        $answerValidation = $this->answerValidate($id);
        $quizPassedValidation = $this->quizPassedValidate();

        $returnData = [
            'success' => false,
        ];

        if (!$questionValidation['success']) {
            $returnData['message'] = $questionValidation['message'];
        } else if (!$answerValidation['success']) {
            $returnData['message'] = $answerValidation['message'];
        } else if (!$quizPassedValidation['success']) {
            $returnData['message'] = $quizPassedValidation['message'];
        }

        if (!isset($returnData['message'])) {
            $returnData['success'] = true;
        }

        return $returnData;
    }
}
