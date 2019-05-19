<?php

namespace app\controllers\admin\album;

use Itstructure\MFUploader\controllers\album\OtherAlbumController as BaseOtherAlbumController;
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};

/**
 * OtherAlbumController
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class OtherAlbumController extends BaseOtherAlbumController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;
}
