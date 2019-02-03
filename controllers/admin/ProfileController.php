<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\RbacModule\controllers\ProfileController as BaseProfileController;

/**
 * Class ProfileController
 * ProfileController implements the CRUD actions for identityClass.
 *
 * @package app\controllers\admin
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class ProfileController extends BaseProfileController
{
    use LanguageTrait, AdminBeforeActionTrait;
}
