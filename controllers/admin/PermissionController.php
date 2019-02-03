<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\RbacModule\controllers\PermissionController as BasePermissionController;

/**
 * Class PermissionController
 * PermissionController implements the CRUD actions for Permission model.
 *
 * @package app\controllers\admin
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class PermissionController extends BasePermissionController
{
    use LanguageTrait, AdminBeforeActionTrait;
}
