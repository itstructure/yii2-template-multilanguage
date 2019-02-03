<?php

namespace app\interfaces;

use yii\rbac\ManagerInterface;
use Itstructure\AdminModule\interfaces\ValidateComponentInterface;

/**
 * Interface UserValidateComponentInterface
 *
 * @package app\interfaces
 */
interface UserValidateComponentInterface extends ValidateComponentInterface
{
    /**
     * Set auth manager.
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void;

    /**
     * Get auth manager.
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface;
}
