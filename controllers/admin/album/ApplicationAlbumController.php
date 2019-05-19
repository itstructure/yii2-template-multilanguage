<?php

namespace app\controllers\admin\album;

use Itstructure\MFUploader\controllers\album\ApplicationAlbumController as BaseApplicationAlbumController;
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};

/**
 * ApplicationAlbumController
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class ApplicationAlbumController extends BaseApplicationAlbumController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;
}
