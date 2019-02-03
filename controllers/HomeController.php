<?php

namespace app\controllers;

use app\models\{Home, About, User};
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;

/**
 * Class HomeController
 *
 * @package app\controllers
 */
class HomeController extends BaseController
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
            ]
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Home::getDefaultHome();

        $this->setMetaParams($model);

        return $this->render('index', [
            'model' => $model,
            'about' => About::getDefaultAbout(),
            'team' => User::getPublicUsers()
        ]);
    }
}
