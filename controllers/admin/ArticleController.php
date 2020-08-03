<?php

namespace app\controllers\admin;

use app\models\{Page, Article, ArticleSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait, AdditionFieldsTrait};
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class ArticleController
 * ArticleController implements the CRUD actions for Article model.
 *
 * @package app\controllers\admin
 */
class ArticleController extends CommonAdminController
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

        $this->additionFields['images'] = $this->getMediaFiles(Article::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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
        $this->additionFields['images'] = $this->getMediaFiles(Article::tableName(), (int)$id, UploadModelInterface::FILE_TYPE_IMAGE);

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
     * Returns Article model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Article::class;
    }

    /**
     * Returns ArticleSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return ArticleSearch::class;
    }
}
