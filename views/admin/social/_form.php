<?php

use yii\helpers\{Url, Html, ArrayHelper};
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Social */
/* @var $form yii\widgets\ActiveForm */
/* @var $contactList app\models\Contact[] */
?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'icon')->textInput()->label(Yii::t('app', 'Icon html class')); ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                    <?php if(!$model->isNewRecord): ?>
                        <?php echo empty($model->icon) ? '' : Html::tag('i', '', ['class' => $model->icon]) ?>
                    <?php endif; ?>
                    <?php echo Html::a('Fontawesome icons', Url::to('https://fontawesome.ru/all-icons/'), [
                        'target' => '_blank'
                    ]); ?>
                    <?php
                    Modal::begin([
                        'header' => '<h2>Fe icons</h2>',
                        'toggleButton' => ['label' => 'Fe icons'],
                    ]);
                    require __DIR__.'/fe-social-icons.php';
                    Modal::end();
                    ?>
                </div>
            </div>

            <?php echo $form->field($model, 'url')->textInput()->label(Yii::t('social', 'Url')); ?>

            <?php echo $form->field($model, 'contacts')
                ->checkboxList(ArrayHelper::map($contactList, 'id', function ($item) {
                    /* @var $item app\models\Contact */
                    return $item->getDefaultTranslate('title');
                }), [
                    'separator' => '<br />',
                ])->label(Yii::t('social', 'Parent contact records')); ?>

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
