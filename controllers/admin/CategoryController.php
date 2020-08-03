<?php

namespace app\controllers\admin;

use app\models\{Category, CategorySearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class CategoryController
 * CategoryController implements the CRUD actions for Page model.
 *
 * @package app\controllers\admin
 */
class CategoryController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

    /**
     * @var bool
     */
    protected $setEditingScenarios = true;

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

        $this->additionFields['categories'] = Category::getMenu();

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

        $this->additionFields['categories'] = Category::getMenu();

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

    /**
     * Returns Category model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Category::class;
    }

    /**
     * Returns CategorySearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return CategorySearch::class;
    }
}
