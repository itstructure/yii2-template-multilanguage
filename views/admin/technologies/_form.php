<?php

use yii\helpers\{Html, ArrayHelper};
use yii\widgets\ActiveForm;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Technology */
/* @var $form yii\widgets\ActiveForm */
/* @var $aboutList app\models\About[] */
?>

<div class="technologies-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'name')->textInput()->label(Yii::t('technologies', 'Name')) ?>

            <?php echo $form->field($model, 'share')->dropDownList(range(0, 100), [
                'style' => 'width: 70px;'
            ])->label(Yii::t('technologies', 'Share')) ?>

            <?php echo $form->field($model, 'about')
                ->checkboxList(ArrayHelper::map($aboutList, 'id', function ($item) {
                    /* @var $item app\models\About */
                    return $item->getDefaultTranslate('title');
                }), [
                    'separator' => '<br />',
                ])->label(Yii::t('technologies', 'Parent about records')) ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
