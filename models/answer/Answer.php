<?php

namespace app\models\answer;

use app\models\questions\Questions;
use app\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $question_id
 * @property int $is_correct
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property Questions $question
 */
class Answer extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'answer';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
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
            [['question_id', 'is_correct', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['question_id' => 'id']],
            //['is_correct', 'compare', 'compareValue' => $this->countCorrect(), 'operator' => '>'],
            ['is_correct', 'countCorrect', 'skipOnError' => false],

        ];
    }

    function countCorrect($attribute, $params)
    {
        $answers = Answer::find()->where(['question_id' => $this->question_id])->all();
        $answerCount = Answer::find()->where(['question_id' => $this->question_id])->count();
        $questionMax = Questions::find()->where(['id' => $this->question_id])->select('max_answers')->scalar();
        $countCorrect = 0;
        if ($this->is_correct == 1) {
            if ($answers) {
                foreach ($answers as $answer) {
                    $countCorrect += $answer->is_correct;
                }
                if ($countCorrect == 1) {
                    $this->addError($attribute, "Question answer already exist correct..");
                }
            }

        }
// else if ($answerCount + 1 == $questionMax ){
//            $this->addError($attribute, "You can't create incorrect answer! because this question don't have correct answer");
//        }

    }

    public function maxAnswerCount($param)
    {
        $rows = Questions::find()
            ->where(['in', 'id', $param])
            ->select('max_answers')
            ->scalar();
        $answer = Answer::find()
            ->where(['in', 'question_id', $param])
            ->count();
        if ($answer >= $rows) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'question_id' => 'Question ID',
            'is_correct' => 'Is Correct',
            'name' => 'Please input answer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->select('username')->scalar();
    }

    public function getUpdatedby()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->select('username')->scalar();
    }
}
