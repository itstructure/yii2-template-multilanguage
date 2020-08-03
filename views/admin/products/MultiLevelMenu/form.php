<?php
use yii\helpers\Html;

/* @var Itstructure\AdminModule\models\MultilanguageValidateModel $model */
/* @var app\models\Category $data */
?>
<?php echo Html::activeRadio($model, 'categoryId', [
    'value' => $data->id,
    'name' => Html::getInputName($model, 'categoryId'),
    'label' => Html::encode($data->getDefaultTranslate('title')),
    'uncheck' => false,
]);  ?>
