<?php

namespace app\components;

use Yii;
use yii\rbac\ManagerInterface;
use yii\base\{Component, InvalidConfigException};
use yii\db\ActiveRecordInterface;
use Itstructure\AdminModule\interfaces\ModelInterface;
use app\models\UserValidate;
use app\interfaces\UserValidateComponentInterface;

/**
 * Class UserValidateComponent
 * Component class for validation user fields.
 *
 * @property bool $changeRoles
 * @property ManagerInterface $authManager
 *
 * @package app\components
 */
class UserValidateComponent extends Component implements UserValidateComponentInterface
{
    /**
     * Allow to change roles.
     *
     * @var bool
     */
    public $changeRoles = true;

    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $authManager;

    /**
     * Initialize.
     */
    public function init()
    {
        if (null === $this->authManager) {
            $this->setAuthManager(Yii::$app->authManager);
        }

        if (null === $this->authManager) {
            throw new InvalidConfigException('The authManager is not defined.');
        }
    }

    /**
     * Set authManager (RBAC).
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Get authManager (RBAC).
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Set a user model for UserValidateComponent.
     *
     * @param ActiveRecordInterface $model
     *
     * @throws InvalidConfigException
     *
     * @return ModelInterface
     */
    public function setModel(ActiveRecordInterface $model): ModelInterface
    {
        /** @var ModelInterface $object */
        $object = Yii::createObject([
            'class' => UserValidate::class,
            'userModel' => $model,
            'authManager' => $this->authManager,
            'changeRoles' => $this->changeRoles,
        ]);

        return $object;
    }
}
