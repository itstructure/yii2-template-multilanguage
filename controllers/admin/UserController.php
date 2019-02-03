<?php

namespace app\controllers\admin;

use Yii;
use yii\base\InvalidConfigException;
use app\traits\{LanguageTrait, AdminBeforeActionTrait};

/**
 * Class UserController
 * UserController implements the CRUD actions for identityClass.
 *
 * @package app\controllers\admin
 */
class UserController extends BaseUserController
{
    use LanguageTrait, AdminBeforeActionTrait;

    /**
     * @return mixed|string
     */
    public function actionIndex()
    {
        if (!$this->checkAccessToIndex()) {
            return $this->accessError();
        }

        $request = Yii::$app->request;

        if ($request->get('id') != null && $request->get('order') != null) {

            if (!$this->checkAccessToAdministrate()) {
                return $this->accessError();
            }

            return $this->actionSetOrder($request->get('id'), $request->get('order'));
        }

        return parent::actionIndex();
    }

    /**
     * @param int $id
     * @param int $order
     *
     * @return \yii\web\Response
     */
    public function actionSetOrder(int $id, int $order)
    {
        /* @var \app\models\User $model */
        $model = $this->findModel($id);
        $model->moveOrder($order);

        return $this->redirect([
            $this->urlPrefix.'index'
        ]);
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
        if ($id != Yii::$app->getUser()->id && !$this->checkAccessToUpdate()) {
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
     * Returns addition fields.
     *
     * @throws InvalidConfigException
     *
     * @return array
     */
    protected function getAdditionFields(): array
    {
        $additionFields = parent::getAdditionFields();

        if ($this->action->id == 'create' || $this->action->id == 'update') {
            return array_merge($additionFields, [
                'changeRoles' => $this->checkAccessToSetRoles()
            ]);
        }

        if ($this->action->id == 'index') {
            return array_merge($additionFields, [
                'administrateAccess' => $this->checkAccessToAdministrate()
            ]);
        }

        return $additionFields;
    }
}
