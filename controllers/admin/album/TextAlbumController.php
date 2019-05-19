<?php

namespace app\controllers\admin\album;

use Itstructure\MFUploader\controllers\album\TextAlbumController as BaseTextAlbumController;
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};

/**
 * TextAlbumController
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class TextAlbumController extends BaseTextAlbumController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;
}
