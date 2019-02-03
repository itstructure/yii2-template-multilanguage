<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;
use app\models\{Page, Product};

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
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Page::find()->where([
            'id' => $id
        ])->andWhere([
            'active' => 1
        ])->one();

        if (null === $model) {
            throw new NotFoundHttpException('Page not fount with id = '.$id.'.');
        }

        $this->setMetaParams($model);

        $productsQuery = Product::find()->where([
            'pageId' => $id
        ])->andWhere([
            'active' => 1
        ]);

        $pagination = new Pagination([
            'totalCount' => $productsQuery->count(),
            'defaultPageSize' => Yii::$app->params['defaultPageSize']
        ]);

        return $this->render('view', [
            'model' => $model,
            'pagination' => $pagination,
            'products' => $productsQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all()
        ]);
    }
}
