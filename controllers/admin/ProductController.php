<?php

namespace app\controllers\admin;

use app\models\{Category, Product, ProductSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait, AdditionFieldsTrait};
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class ProductController
 * ProductController implements the CRUD actions for Page model.
 *
 * @package app\controllers\admin
 */
class ProductController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait, AdditionFieldsTrait;

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

        $this->additionFields['images'] = $this->getMediaFiles(Product::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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
        $this->additionFields['albums'] = $this->getAlbums();

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
        $this->additionFields['albums'] = $this->getAlbums();
        $this->additionFields['images'] = $this->getMediaFiles(Product::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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
     * Returns Product model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Product::class;
    }

    /**
     * Returns ProductSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return ProductSearch::class;
    }
}
