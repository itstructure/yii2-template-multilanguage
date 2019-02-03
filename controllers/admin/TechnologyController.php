<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use app\models\{About, Technology, TechnologySearch};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class TechnologyController
 * TechnologyController implements the CRUD actions for Technology model.
 *
 * @package app\controllers\admin
 */
class TechnologyController extends CommonAdminController
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
                'aboutList' => About::find()->all(),
            ];
        }

        return $this->additionFields;
    }

    /**
     * Returns Technology model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Technology::class;
    }

    /**
     * Returns TechnologySearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return TechnologySearch::class;
    }
}
