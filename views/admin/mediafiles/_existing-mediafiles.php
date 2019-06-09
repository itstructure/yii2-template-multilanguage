<?php
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\widgets\LinkPager;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\MFUploader\Module;
use Itstructure\MFUploader\models\Mediafile;
use Itstructure\MFUploader\widgets\FileSetter;
use Itstructure\MFUploader\assets\FileSetterAsset;
use Itstructure\AdminModule\models\MultilanguageValidateModel;

/* @var $this yii\web\View */
/* @var $model ActiveRecord|MultilanguageValidateModel */
/* @var $mediafiles Mediafile[] */
/* @var $mediafile Mediafile */
/* @var $pages Pagination */
/* @var $fileType string */
/* @var $ownerParams array */
/* @var $baseUrl string */

$baseUrl = FileSetterAsset::register($this)->baseUrl;
?>

<style>
    .file-item {
        margin-bottom: 15px;
    }
</style>

<div class="row">
    <?php $i=0; ?>
    <?php foreach ($mediafiles as $mediafile): ?>
        <div class="col-md-6 file-item">
            <?php $i+=1; ?>
            <div class="media">
                <div class="media-left" id="mediafile-container-<?php echo $i; ?>">
                    <?php echo $mediafile->getPreview($baseUrl, 'existing', $mediafile->isImage() ? [
                        'externalTag' => [
                            'name' => 'a',
                            'options' => [
                                'href' => $mediafile->url,
                                'target' => '_blank'
                            ]
                        ]
                    ] : []); ?>
                </div>
                <div class="media-body">
                    <h4 id="title-container-<?php echo $i; ?>" class="media-heading">
                        <?php echo $mediafile->title ?>
                    </h4>
                    <div id="description-container-<?php echo $i; ?>">
                        <?php echo $mediafile->description ?>
                    </div>
                </div>
            </div>
            <?php echo FileSetter::widget(ArrayHelper::merge([
                    'model' => $model,
                    'attribute' => $fileType.'[]',
                    'neededFileType' => $fileType,
                    'buttonName' => Module::t('main', 'Set '.$fileType),
                    'resetButtonName' => Module::t('main', 'Clear'),
                    'options' => [
                        'id' => Html::getInputId($model, $fileType) . '-' . $i,
                        'value' => $mediafile->{FileSetter::INSERTED_DATA_ID},
                    ],
                    'deleteBoxDisplay' => true,
                    'deleteBoxName' => Module::t('main', 'Delete'),
                    'deleteBoxOptions' => [
                        'value' => $mediafile->id
                    ],
                    'mediafileContainer' => '#mediafile-container-' . $i,
                    'titleContainer' => '#title-container-' . $i,
                    'descriptionContainer' => '#description-container-' . $i,
                    'subDir' => $model->mainModel->tableName()
                ], isset($ownerParams) && is_array($ownerParams) ? ArrayHelper::merge([
                    'ownerAttribute' => $fileType
                ], $ownerParams) : [])
            ); ?>
        </div>
    <?php endforeach; ?>
</div>

<?php echo LinkPager::widget(['pagination' => $pages]) ?>
