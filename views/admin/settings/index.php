<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('settings', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'initUserStatus')->dropDownList([
                1 => Yii::t('app', 'Active'),
                0 => Yii::t('app', 'Blocked')
            ], [
                'prompt' => Yii::t('app', 'Not chosen')
            ])->label(Yii::t('settings', 'User status after registration')) ?>

            <?php echo $form->field($model, 'initUserRole')->dropDownList(ArrayHelper::map($roles, 'name', 'name'), [
                'prompt' => 'Not chosen'
            ])->label(Yii::t('settings', 'User role after registration')) ?>

            <?php echo $form->field($model, 'regBlock')->dropDownList([
                0 => Yii::t('settings', 'Registration active'),
                1 => Yii::t('settings', 'Registration blocked')
            ], [
                'prompt' => Yii::t('app', 'Not chosen')
            ])->label(Yii::t('settings', 'Block registration')) ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Update'),
            ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
