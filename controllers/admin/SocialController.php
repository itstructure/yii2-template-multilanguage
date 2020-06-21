<?php

namespace app\controllers\admin;

use app\models\{Contact, Social, SocialSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class SocialController
 * SocialController implements the CRUD actions for Social model.
 *
 * @package app\controllers\admin
 */
class SocialController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

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
            return [
                'contactList' => Contact::find()->all(),
            ];
        }

        return $this->additionFields;
    }

    /**
     * Returns Social model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Social::class;
    }

    /**
     * Returns SocialSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return SocialSearch::class;
    }
}
