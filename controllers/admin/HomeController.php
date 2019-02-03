<?php

namespace app\controllers\admin;

use yii\web\NotFoundHttpException;
use app\models\{Home, HomeSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class HomeController
 * HomeController implements the CRUD actions for Home model.
 *
 * @package app\controllers\admin
 */
class HomeController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

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
        if (!$this->checkAccessToUpdate()) {
            return $this->accessError();
        }

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

    /**
     * @return mixed|string
     */
    public function actionIndex()
    {
        if (!$this->checkAccessToIndex()) {
            return $this->accessError();
        }

        return parent::actionIndex();
    }

    /**
     * @param int|string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        if (!$this->checkAccessToView()) {
            return $this->accessError();
        }

        return parent::actionView($id);
    }

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!$this->checkAccessToCreate()) {
            return $this->accessError();
        }

        return parent::actionCreate();
    }

    /**
     * @param int|string $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        if (!$this->checkAccessToUpdate()) {
            return $this->accessError();
        }

        return parent::actionUpdate($id);
    }

    /**
     * @param int|string $id
     *
     * @return mixed|\yii\web\Response
     */
    public function actionDelete($id)
    {
        if (!$this->checkAccessToDelete()) {
            return $this->accessError();
        }

        return parent::actionDelete($id);
    }
}
