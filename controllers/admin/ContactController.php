<?php

namespace app\controllers\admin;

use yii\web\NotFoundHttpException;
use app\models\{Contact, ContactSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class ContactController
 * ContactController implements the CRUD actions for Contact model.
 *
 * @package app\controllers\admin
 */
class ContactController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

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
}
