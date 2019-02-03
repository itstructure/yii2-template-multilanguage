<?php

namespace app\controllers\admin;

use yii\web\NotFoundHttpException;
use app\models\{Contact, ContactSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class ContactController
 * ContactController implements the CRUD actions for Contact model.
 *
 * @package app\controllers\admin
 */
class ContactController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

    /**
     * Set contacts record as default.
     *
     * @param $contactId
     *
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionSetDefault($contactId)
    {
        if (!$this->checkAccessToUpdate()) {
            return $this->accessError();
        }

        $contact = Contact::findOne($contactId);

        if (null === $contact) {
            throw  new NotFoundHttpException('Record with id ' . $contactId . ' does not exist');
        }

        $contact->default = 1;
        $contact->save();

        return $this->redirect('index');
    }

    /**
     * Returns Contact model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Contact::class;
    }

    /**
     * Returns ContactSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return ContactSearch::class;
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
