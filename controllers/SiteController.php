<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\{LoginForm, RegForm};

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['reg', 'login', 'captcha'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     *
     * @return Response|string
     */
    public function actionReg()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /* @var $settingModel \app\models\Setting */
        $settingModel = Yii::$app->get('settings')
            ->setModel()
            ->getSettings();

        if ($settingModel->regBlock == 1) {
            return $this->render('regBlock');
        }

        $model = new RegForm();

        if ($model->load(Yii::$app->request->post()) && $model->reg()) {

            if (Yii::$app->getUser()->login($model->getUser())) {
                return $this->goHome();
            }
        }

        return $this->render('reg', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
