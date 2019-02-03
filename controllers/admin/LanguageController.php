<?php

namespace app\controllers\admin;

use app\traits\{LanguageTrait, AdminBeforeActionTrait};
use Itstructure\AdminModule\controllers\LanguageController as BaseLanguageController;

/**
 * Class LanguageController
 * LanguageController implements the CRUD actions for Language model.
 *
 * @package app\controllers\admin
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class LanguageController extends BaseLanguageController
{
    use LanguageTrait, AdminBeforeActionTrait;
}
