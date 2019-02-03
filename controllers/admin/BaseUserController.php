<?php

namespace app\controllers\admin;

use Yii;
use yii\base\InvalidConfigException;
use app\components\UserValidateComponent;
use app\interfaces\UserValidateComponentInterface;
use app\traits\AccessTrait;
use app\models\Position;
use Itstructure\AdminModule\controllers\CommonAdminController;

/**
 * Class BaseUserController
 * BaseUserController implements the CRUD actions for identityClass.
 *
 * @property UserValidateComponentInterface|UserValidateComponent $validateComponent Validate component.
 *
 * @package app\controllers\admin
 */
class BaseUserController extends CommonAdminController
{
    use AccessTrait;

    /**
     * Initialize.
     * Set validateComponent and additionFields.
     */
    public function init()
    {
        $this->validateComponent = Yii::$app->get('user-validate');
        $this->validateComponent->changeRoles = $this->checkAccessToSetRoles();

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
            $additionFields['positions'] = Position::getPositions();
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
