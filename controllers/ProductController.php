<?php

namespace app\controllers;

use yii\web\NotFoundHttpException;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;
use app\models\Product;

/**
 * Class ProductController
 *
 * @package app\controllers
 */
class ProductController extends BaseController
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
     * Displays product page.
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Product::find()->where([
            'id' => $id
        ])->andWhere([
            'active' => 1
        ])->one();

        if (null === $model) {
            throw new NotFoundHttpException('Product not fount with id = '.$id.'.');
        }

        $this->setMetaParams($model);

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
