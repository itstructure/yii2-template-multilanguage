<?php
use yii\helpers\{ArrayHelper, Html};
use yii\db\ActiveRecord;
use Itstructure\MFUploader\Module;
use Itstructure\MFUploader\widgets\FileSetter;
use Itstructure\AdminModule\models\MultilanguageValidateModel;

/* @var $this yii\web\View */
/* @var $model ActiveRecord|MultilanguageValidateModel */
/* @var $fileType string */
/* @var $ownerParams array */
/* @var $number int */
?>

<div class="media">
    <div class="media-left" id="mediafile-container-new<?php if (isset($number)): ?>-<?php echo $number; ?><?php endif; ?>">
    </div>
    <div class="media-body">
        <h4 id="title-container-new<?php if (isset($number)): ?>-<?php echo $number; ?><?php endif; ?>" class="media-heading"></h4>
        <div id="description-container-new<?php if (isset($number)): ?>-<?php echo $number; ?><?php endif; ?>"></div>
    </div>
</div>

<?php echo FileSetter::widget(ArrayHelper::merge([
        'model' => $model,
        'attribute' => $fileType.'[]',
        'neededFileType' => $fileType,
        'buttonName' => Module::t('main', 'Set '.$fileType),
        'resetButtonName' => Module::t('main', 'Clear'),
        'options' => [
            'id' => Html::getInputId($model, $fileType) . (isset($number) ? '-new-' . $number : '')
        ],
        'mediafileContainer' => '#mediafile-container-new' . (isset($number) ? '-' . $number : ''),
        'titleContainer' => '#title-container-new' . (isset($number) ? '-' . $number : ''),
        'descriptionContainer' => '#description-container-new' . (isset($number) ? '-' . $number : ''),
        'subDir' => $model->mainModel->tableName()
    ], isset($ownerParams) && is_array($ownerParams) ? ArrayHelper::merge([
        'ownerAttribute' => $fileType
    ], $ownerParams) : [])
); ?>
