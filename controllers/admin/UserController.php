<?php

namespace app\controllers\admin;

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
}
