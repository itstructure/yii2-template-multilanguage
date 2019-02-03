<?php
use yii\helpers\Html;

/* @var Itstructure\AdminModule\models\MultilanguageValidateModel $model */
/* @var app\models\Page $data */
?>
<?php echo Html::activeRadio($model, 'pageId', [
    'value' => $data->id,
    'name' => Html::getInputName($model, 'pageId'),
    'label' => Html::encode($data->getDefaultTranslate('title')),
    'uncheck' => false,
]);  ?>
