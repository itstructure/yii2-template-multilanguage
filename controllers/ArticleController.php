<?php

namespace app\controllers;

use yii\web\NotFoundHttpException;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;
use app\models\Article;

/**
 * Class ArticleController
 *
 * @package app\controllers
 */
class ArticleController extends BaseController
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
     * Displays article page.
     *
     * @param $alias
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        $model = Article::find()->where([
            'alias' => $alias
        ])->andWhere([
            'active' => 1
        ])->one();

        if (null === $model) {
            throw new NotFoundHttpException('Article not fount with alias = '.$alias.'.');
        }

        $this->setMetaParams($model);

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
