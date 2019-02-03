<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use yii\web\NotFoundHttpException;
use app\models\{About, AboutSearch};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class AboutController
 * AboutController implements the CRUD actions for About model.
 *
 * @package app\controllers\admin
 */
class AboutController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

    /**
     * Set about record as default.
     *
     * @param $aboutId
     *
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionSetDefault($aboutId)
    {
        if (!$this->checkAccessToUpdate()) {
            return $this->accessError();
        }

        $about = About::findOne($aboutId);

        if (null === $about) {
            throw  new NotFoundHttpException('Record with id ' . $aboutId . ' does not exist');
        }

        $about->default = 1;
        $about->save();

        return $this->redirect('index');
    }

    /**
     * Returns About model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return About::class;
    }

    /**
     * Returns AboutSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return AboutSearch::class;
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
