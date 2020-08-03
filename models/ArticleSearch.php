<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\{ActiveDataProvider, Pagination};

/**
 * ArticleSearch represents the model behind the search form of `app\models\Article`.
 *
 * @package app\models
 */
class ArticleSearch extends Article
{
    /**
     * @var string
     */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'pageId',
                    'active',
                ],
                'integer',
            ],
            [
                'title',
                'string',
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
        $query = Article::find()->joinWith(['articlesLanguages']);

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
            'pageId' => $this->pageId,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'articles_language.title', $this->title]);

        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['defaultPageSize'],
            'totalCount' => $query->count(),
        ]);

        $dataProvider->setPagination($pagination);

        return $dataProvider;
    }
}
