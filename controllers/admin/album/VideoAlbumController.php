<?php

namespace app\controllers\admin\album;

use Itstructure\MFUploader\controllers\album\VideoAlbumController as BaseVideoAlbumController;
use app\traits\{LanguageTrait, AdminBeforeActionTrait, AccessTrait};

/**
 * VideoAlbumController
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class VideoAlbumController extends BaseVideoAlbumController
{
    use LanguageTrait, AdminBeforeActionTrait, AccessTrait;
}
