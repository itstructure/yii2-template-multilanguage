<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-search">

    <?php $form = ActiveForm::begin([
        'action' => [
            $this->params['urlPrefix'].'index'
        ],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'description') ?>

    <?php echo $form->field($model, 'created_at') ?>

    <?php echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
