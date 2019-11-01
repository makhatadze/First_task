<?php

namespace app\models;

use app\models\answer\Answer;
use Faker\Calculator\TCNo;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quiz;

/**
 * QuizSearch represents the model behind the search form of `app\models\Quiz`.
 */
class QuizSearch extends Quiz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'min_corect_answer',], 'integer'],
            [['subject'], 'safe'],
            [['created_at', 'update_at'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Quiz::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $dayInSeconds = 86400;


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->created_at) {
            $query->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $this->created_at
            ]);
        }
        if ($this->update_at) {
            $query->andFilterWhere([
                'like',
                'FROM_UNIXTIME(update_at, "%Y-%m-%d")',
                $this->update_at
            ]);;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'min_corect_answer' => $this->min_corect_answer,

        ]);
        $query->andFilterWhere(['like', 'subject', $this->subject]);

        return $dataProvider;
    }
}
