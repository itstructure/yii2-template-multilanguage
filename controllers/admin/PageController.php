<?php

namespace app\controllers\admin;

use app\models\{Page, PageSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait, AdditionFieldsTrait};
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class PageController
 * PageController implements the CRUD actions for Page model.
 *
 * @package app\controllers\admin
 */
class PageController extends CommonAdminController
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

        $this->additionFields['images'] = $this->getMediaFiles(Page::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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

        $this->additionFields['pages'] = Page::getMenu();
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

        $this->additionFields['pages'] = Page::getMenu();
        $this->additionFields['albums'] = $this->getAlbums();
        $this->additionFields['images'] = $this->getMediaFiles(Page::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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
     * Returns Page model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Page::class;
    }

    /**
     * Returns PageSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return PageSearch::class;
    }
}
