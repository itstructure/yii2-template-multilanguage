<?php

namespace app\controllers;

use Yii;
use yii\filters\{AccessControl, VerbFilter};
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\{Contact, Feedback};

/**
 * Class ContactController
 *
 * @package app\controllers
 */
class ContactController extends BaseController
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
                        'actions' => ['index', 'captcha'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'captcha' => ['get'],
                ],
            ],
        ]);
    }

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
     * Displays contacts page.
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $feedback = new Feedback();
        $feedback->setScenario(Feedback::SCENARIO_CONTACT);

        if ($feedback->load(Yii::$app->request->post()) && $feedback->contact(Yii::$app->params['adminEmail'])) {

            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        $model = Contact::getDefaultContacts();

        if (null === $model) {
            throw new NotFoundHttpException('Contacts not fount.');
        }

        $this->setMetaParams($model);

        return $this->render('index', [
            'model' => $model,
            'feedback' => $feedback
        ]);
    }
}
