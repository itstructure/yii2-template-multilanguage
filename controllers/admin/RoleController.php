<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\RbacModule\controllers\RoleController as BaseRoleController;

/**
 * Class RoleController
 * RoleController implements the CRUD actions for Role model.
 *
 * @package app\controllers\admin
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class RoleController extends BaseRoleController
{
    use LanguageTrait, AdminBeforeActionTrait;
}
