<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};
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
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;

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
