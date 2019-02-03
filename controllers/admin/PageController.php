<?php

namespace app\controllers\admin;

use app\models\{Page, PageSearch};
use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class PageController
 * PageController implements the CRUD actions for Page model.
 *
 * @package app\controllers\admin
 */
class PageController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

    /**
     * @var bool
     */
    protected $isMultilanguage = true;

    /**
     * Get addition fields for the view template.
     * @return array
     */
    protected function getAdditionFields(): array
    {
        if ($this->action->id == 'create' || $this->action->id == 'update') {
            return [
                'pages' => Page::getMenu()
            ];
        }

        return $this->additionFields;
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
