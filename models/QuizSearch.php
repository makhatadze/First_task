<?php

namespace app\models;

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
            [['id', 'certificate_valid_time',
                'min_corect_answer', 'created_at', 'update_at', 'max_question', 'created_by', 'updated_by',],
                'integer'],
            [['subject'], 'safe'],
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
            if($this->created_at){
                $createStart = strtotime($this->created_at);
                $createEnd = $createStart + 86400;
                $query->andFilterWhere([
                    'between', 'created_at', $createStart, $createEnd
                ]);
                $query->andFilterWhere([
                    'id' => $this->id,
                    'min_corect_answer' => $this->min_corect_answer,
                ]);
                $query->andFilterWhere(['like', 'subject', $this->subject]);
            }
            if($this->update_at){
                $updateStart = strtotime($this->update_at);
                $updateEnd = $updateStart + 86400;
                $query->andFilterWhere([
                    'between', 'update_at', $updateStart, $updateEnd
                ]);
                $query->andFilterWhere([
                    'id' => $this->id,
                    'min_corect_answer' => $this->min_corect_answer,
                ]);
                $query->andFilterWhere(['like', 'subject', $this->subject]);
            }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
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
