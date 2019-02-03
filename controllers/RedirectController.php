<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use Itstructure\AdminModule\models\Language;
use app\helpers\BaseHelper;

/**
 * Class RedirectController
 *
 * @package app\controllers
 */
class RedirectController extends Controller
{
    /**
     * Redirect to home page with default language.
     */
    public function actionHomePage()
    {
        $clientShortLanguage = BaseHelper::detectClientShortLanguage();

        if (null === $clientShortLanguage) {
            $shortLanguage = Language::getDefaultLanguage()->shortName;

        } else {
            $check = Language::find()->where([
                'shortName' => $clientShortLanguage
            ])->count();

            $shortLanguage = $check == 0 ? Language::getDefaultLanguage()->shortName : $clientShortLanguage;
        }

        Yii::$app->response->redirect('/'.$shortLanguage, 302)->send();
    }
}
