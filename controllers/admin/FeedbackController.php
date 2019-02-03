<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use app\models\{Feedback, FeedbackSearch};
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class FeedbackController
 * FeedbackController implements the CRUD actions for Page model.
 *
 * @package app\controllers\admin
 */
class FeedbackController extends CommonAdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

    /**
     * Set read status to "1" after view record.
     *
     * @param \yii\base\Action $action
     * @param mixed $result
     *
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        if ($action->id == 'view') {
            $modelId = $action->controller->actionParams['id'];
            Feedback::fixReadStatus((int)$modelId);
        }

        return parent::afterAction($action, $result);
    }

    /**
     * Returns Product model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Feedback::class;
    }

    /**
     * Returns ProductSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return FeedbackSearch::class;
    }
}
