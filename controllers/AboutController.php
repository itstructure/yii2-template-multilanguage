<?php

namespace app\controllers;

use app\models\About;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;

/**
 * Class AboutController
 *
 * @package app\controllers
 */
class AboutController extends BaseController
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
                        'actions' => ['index'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = About::getDefaultAbout();

        $this->setMetaParams($model);

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
