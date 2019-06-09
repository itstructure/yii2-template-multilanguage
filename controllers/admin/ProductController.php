<?php

namespace app\controllers\admin;

use yii\data\Pagination;
use app\models\{Page, Product, ProductSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\MFUploader\models\OwnerMediafile;
use Itstructure\MFUploader\models\album\Album;
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
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

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

    /**
     * Get addition fields for the view template.
     *
     * @return array
     */
    protected function getAdditionFields(): array
    {
        if ($this->action->id == 'create' || $this->action->id == 'update') {
            $fields = [];

            $fields['pages'] = Page::getMenu();
            $fields['albums'] = Album::find()->select([
                'id', 'title'
            ])->all();

            if ($this->action->id == 'update') {
                $mediafilesQuery = OwnerMediafile::getMediaFilesQuery([
                    'owner' => Product::tableName(),
                    'ownerId' => $this->model->getId(),
                    'ownerAttribute' => UploadModelInterface::FILE_TYPE_IMAGE,
                ]);
                $media_pages = new Pagination([
                    'defaultPageSize' => 6,
                    'totalCount' => $mediafilesQuery->count()
                ]);
                $fields['images'] = $mediafilesQuery->offset($media_pages->offset)
                    ->limit($media_pages->limit)
                    ->all();
                $fields['media_pages'] = $media_pages;
            }

            return $fields;
        }

        return $this->additionFields;
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
