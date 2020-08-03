<?php
use yii\helpers\Html;
use Itstructure\MultiLevelMenu\MenuWidget;

/* @var Itstructure\AdminModule\models\MultilanguageValidateModel $model */
/* @var app\models\Category $data */
/* @var app\models\Category $mainModel */

$mainModel = $model->mainModel;
?>
<?php echo Html::activeRadio($model, 'parentId', [
    'value' => $data->id,
    'name' => Html::getInputName($model, 'parentId'),
    'label' => Html::encode($data->getDefaultTranslate('title')),
    'disabled' => !MenuWidget::checkNewParentId($mainModel, $data->id),
    //'uncheck' => false,
    'onMouseDown' => 'this.isChecked=this.checked;',
    'onClick' => 'this.checked=!this.isChecked;',
]);  ?>
