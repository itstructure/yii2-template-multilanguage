<?php

use yii\helpers\ArrayHelper;
use Itstructure\MFUploader\Module;
use Itstructure\MFUploader\widgets\FileSetter;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\AdminModule\models\MultilanguageValidateModel;
use app\models\Page;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Page|MultilanguageValidateModel */
/* @var $ownerParams array */
?>

<div id="thumbnail-container">
    <?php echo $model->mainModel->getDefaultThumbImage(); ?>
</div>
<?php echo FileSetter::widget(ArrayHelper::merge([
        'model' => $model,
        'attribute' => UploadModelInterface::FILE_TYPE_THUMB,
        'neededFileType' => UploadModelInterface::FILE_TYPE_THUMB,
        'buttonName' => Module::t('main', 'Set thumbnail'),
        'resetButtonName' => Module::t('main', 'Clear'),
        'options' => [
            'value' => ($thumbnailModel = $model->mainModel->getThumbnailModel()) !== null ? $thumbnailModel->{FileSetter::INSERTED_DATA_ID} : null,
        ],
        'mediafileContainer' => '#thumbnail-container',
        'subDir' => $model->mainModel->tableName()
    ], isset($ownerParams) && is_array($ownerParams) ? ArrayHelper::merge([
        'ownerAttribute' => UploadModelInterface::FILE_TYPE_THUMB
    ], $ownerParams) : [])
); ?>
