<?php

namespace app\controllers\admin;

use app\models\{Contact, Social, SocialSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class SocialController
 * SocialController implements the CRUD actions for Social model.
 *
 * @package app\controllers\admin
 */
class SocialController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

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
