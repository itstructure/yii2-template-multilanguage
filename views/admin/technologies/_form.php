<?php

use yii\helpers\{Url, Html, ArrayHelper};
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

            <?php echo $form->field($model, 'icon')->textInput([
                'maxlength' => true,
                'style' => 'width: 25%;'
            ])->label(Yii::t('app', 'Icon html class')); ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-4">
                    <?php if(!$model->isNewRecord): ?>
                        <?php echo Html::tag('i', '', ['class' => empty($model->icon) ? 'fa fa-file fa-2x' : $model->icon]) ?>
                    <?php endif; ?>
                    <?php echo Html::a('Fontawesome icons', Url::to('https://fontawesome.ru/all-icons/'), [
                        'target' => '_blank'
                    ]); ?>
                </div>
            </div>

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
