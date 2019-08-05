<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contest;

/**
 * ContestSearch represents the model behind the search form of `common\models\Contest`.
 */
class ContestSearch extends Contest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'description_ru', 'status', 'public', 'result_panel', 'voters_limit', 'range'], 'integer'],
            [['title_en', 'description_en', 'title_ru', 'start_date', 'end_date', 'permalink', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $titlesEqually = false )
    {
        $query = Contest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['end_date'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($titlesEqually) {
            $this->title_ru = $this->title_en;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'description_ru' => $this->description_ru,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'public' => $this->public,
            'result_panel' => $this->result_panel,
            'voters_limit' => $this->voters_limit,
            'range' => $this->range,
            'status' => $this->status,
        ]);

        if($titlesEqually) {
            $query->orFilterWhere(['like', 'title_ru',$this->title_en])
                ->orFilterWhere(['like', 'title_en',$this->title_en]);
        } else {
            $query->andFilterWhere(['like', 'title_en', $this->title_en])
              ->andFilterWhere(['like', 'title_ru', $this->title_ru]);
        }

        $query->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere(['like', 'permalink', $this->permalink])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        $query->andFilterWhere(['status' => Contest::STATUS_ACTIVE]);

        return $dataProvider;
    }
}
