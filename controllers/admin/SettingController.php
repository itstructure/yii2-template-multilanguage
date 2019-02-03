<?php

namespace app\controllers\admin;

use Yii;
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\AdminModule\controllers\AdminController;

/**
 * Class SettingController
 * SettingController implements the CRUD actions for Setting model.
 *
 * @package app\controllers\admin
 */
class SettingController extends AdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

    /**
     * List of records.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->checkAccessToAdministrate()) {
            return $this->accessError();
        }

        /* @var $model \app\models\Setting */
        $model = Yii::$app->get('settings')
            ->setModel()
            ->getSettings();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                '/'.$this->shortLanguage.'/admin/settings'
            ]);
        }

        $fields = [
            'model' => $model,
            'roles' => Yii::$app->authManager->getRoles()
        ];

        return $this->render('index', $fields);
    }
}
