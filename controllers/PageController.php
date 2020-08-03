<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;
use app\models\{Page, Article};

/**
 * Class PageController
 *
 * @package app\controllers
 */
class PageController extends BaseController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ]);
    }

    /**
     * Displays Ppage.
     *
     * @param $alias
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        $model = Page::find()->where([
            'alias' => $alias
        ])->andWhere([
            'active' => 1
        ])->one();

        if (null === $model) {
            throw new NotFoundHttpException('Page not fount with alias = '.$alias.'.');
        }

        $this->setMetaParams($model);

        $articlesQuery = Article::find()->where([
            'pageId' => $model->id
        ])->andWhere([
            'active' => 1
        ]);

        $pagination = new Pagination([
            'totalCount' => $articlesQuery->count(),
            'defaultPageSize' => Yii::$app->params['defaultPageSize']
        ]);

        return $this->render('view', [
            'model' => $model,
            'pagination' => $pagination,
            'articles' => $articlesQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all()
        ]);
    }
}
