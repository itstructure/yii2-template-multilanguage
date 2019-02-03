<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[role="clear-button"]').on("click", function(e) {
            e.preventDefault();
            $("input[type=radio]").each(function(){
                $(this).prop("checked",false);
            });
            $("input[type=text]").each(function(){
                $(this).prop("value","");
            });
        });
    });
</script>

<div class="feedback-search">

    <?php $form = ActiveForm::begin([
        'action' => [
            $this->params['urlPrefix'].'index'
        ],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'read')
                ->radioList([0 => Yii::t('feedback', 'New'), 1 => Yii::t('feedback', 'Read')])
                ->label(Yii::t('feedback', 'Read status')); ?>

            <?php echo $form->field($model, 'name')->label(Yii::t('feedback', 'Name')) ?>

            <?php echo $form->field($model, 'email')->label(Yii::t('feedback', 'Email')) ?>

            <?php echo $form->field($model, 'phone')->label(Yii::t('feedback', 'Phone')) ?>

            <?php echo $form->field($model, 'subject')->label(Yii::t('feedback', 'Subject')) ?>

            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default', 'role' => 'clear-button']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
