<?php

namespace app\controllers\admin;

use yii\web\NotFoundHttpException;
use app\models\{Home, HomeSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class HomeController
 * HomeController implements the CRUD actions for Home model.
 *
 * @package app\controllers\admin
 */
class HomeController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

    /**
     * Set home record as default.
     *
     * @param $homeId
     *
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionSetDefault($homeId)
    {
        $home = Home::findOne($homeId);

        if (null === $home) {
            throw  new NotFoundHttpException('Record with id ' . $homeId . ' does not exist');
        }

        $home->default = 1;
        $home->save();

        return $this->redirect('index');
    }

    /**
     * Returns Home model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Home::class;
    }

    /**
     * Returns HomeSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return HomeSearch::class;
    }
}
