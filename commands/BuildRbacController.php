<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\rbac\BaseManager;
use yii\rbac\Item;

/**
 * Class BuildRbacController
 *
 * @package app\commands
 */
class BuildRbacController extends Controller
{
    /**
     * @var BaseManager
     */
    private $authManager;

    public function init()
    {
        $this->authManager = Yii::$app->get('authManager');

        parent::init();
    }

    /**
     * @return int
     */
    public function actionIndex()
    {
        /* CREATE ROLES */
        $this->tryCreateRole('admin', 'Admin role');
        $this->tryCreateRole('manager', 'Manager');
        $this->tryCreateRole('user', 'Simple user');

        /* CREATE PERMISSIONS */
        $this->tryCreatePermission('CREATE', 'Create entries');
        $this->tryCreatePermission('UPDATE', 'Update entries');
        $this->tryCreatePermission('DELETE', 'Delete entries');
        $this->tryCreatePermission('SET_ROLES', 'Set roles for users');
        $this->tryCreatePermission('VIEW_BACKSIDE', 'View back side content');
        $this->tryCreatePermission('VIEW_FRONTSIDE', 'View front side content');

        /* DEFINE PERMISSIONS TO ROLES */
        $item_role_admin = $this->authManager->getRole('admin');
        $item_role_manager = $this->authManager->getRole('manager');
        $item_role_user = $this->authManager->getRole('user');

        $item_permission_create = $this->authManager->getPermission('CREATE');
        $item_permission_update = $this->authManager->getPermission('UPDATE');
        $item_permission_delete = $this->authManager->getPermission('DELETE');
        $item_permission_set_roles = $this->authManager->getPermission('SET_ROLES');
        $item_permission_view_backside = $this->authManager->getPermission('VIEW_BACKSIDE');
        $item_permission_view_frontside = $this->authManager->getPermission('VIEW_FRONTSIDE');

        $this->tryAddChild($item_role_admin, $item_permission_create);
        $this->tryAddChild($item_role_admin, $item_permission_update);
        $this->tryAddChild($item_role_admin, $item_permission_delete);
        $this->tryAddChild($item_role_admin, $item_permission_set_roles);
        $this->tryAddChild($item_role_admin, $item_permission_view_backside);
        $this->tryAddChild($item_role_admin, $item_permission_view_frontside);


        $this->tryAddChild($item_role_manager, $item_permission_view_backside);
        $this->tryAddChild($item_role_manager, $item_permission_view_frontside);

        $this->tryAddChild($item_role_user, $item_permission_view_frontside);

        echo 'Done' . "\n";

        return ExitCode::OK;
    }

    /**
     * @param string $name
     * @param string $description
     */
    private function tryCreateRole(string $name, string $description): void
    {
        if (empty($this->authManager->getRole($name))) {
            $item_role = $this->authManager->createRole($name);
            $item_role->description = $description;
            $this->authManager->add($item_role);
        }
    }

    /**
     * @param string $name
     * @param string $description
     */
    private function tryCreatePermission(string $name, string $description): void
    {
        if (empty($this->authManager->getPermission($name))) {
            $item_permission = $this->authManager->createPermission($name);
            $item_permission->description = $description;
            $this->authManager->add($item_permission);
        }
    }

    /**
     * @param Item $item_role
     * @param Item $item_permission
     */
    private function tryAddChild(Item $item_role, Item $item_permission): void
    {
        if (!$this->authManager->hasChild($item_role, $item_permission)) {
            $this->authManager->addChild($item_role, $item_permission);
        }
    }
}
