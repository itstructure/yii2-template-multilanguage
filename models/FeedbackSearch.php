<?php

namespace app\models;

use yii\base\Model;
use yii\data\{ActiveDataProvider, Pagination};

/**
 * FeedbackSearch represents the model behind the search form of `app\models\Feedback`.
 *
 * @package app\models
 */
class FeedbackSearch extends Feedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'read',
                'integer',
            ],
            [
                [
                    'name',
                    'phone',
                    'subject',
                ],
                'string'
            ],
            [
                'email',
                'email'
            ],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Feedback::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'read' => $this->read,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $query->andFilterWhere([
            'like',
            'name',
            $this->name
        ]);

        $query->andFilterWhere([
            'like',
            'subject',
            $this->subject
        ]);

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);

        $dataProvider->setPagination($pagination);

        return $dataProvider;
    }
}
