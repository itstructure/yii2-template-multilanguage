<?php

namespace app\controllers\admin;

use Yii;
use yii\base\InvalidConfigException;
use app\interfaces\UserValidateComponentInterface;
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class BaseUserController
 * BaseUserController implements the CRUD actions for identityClass.
 *
 * @property UserValidateComponentInterface $validateComponent Validate component.
 *
 * @package app\controllers\admin
 */
class BaseUserController extends CommonAdminController
{
    /**
     * Initialize.
     * Set validateComponent and additionFields.
     */
    public function init()
    {
        $this->validateComponent = Yii::$app->get('user-validate');

        parent::init();
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
        $additionFields = [];

        if ($this->action->id == 'create' || $this->action->id == 'update') {
            $additionFields['roles'] = $this->validateComponent->getAuthManager()->getRoles();
        }

        return $additionFields;
    }

    /**
     * Returns identityClass model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return \Yii::$app->user->identityClass;
    }

    /**
     * Returns identityClass Search model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return \Yii::$app->user->identityClass . 'Search';
    }
}
