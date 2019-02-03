<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\AdminModule\models\Language;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Contact|Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php echo Fields::widget([
                'fields' => [
                    [
                        'name' => 'title',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('contacts', 'Title'),
                    ],
                    [
                        'name' => 'address',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('contacts', 'Address'),
                    ],
                    [
                        'name' => 'email',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('contacts', 'Email'),
                    ],
                    [
                        'name' => 'phone',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('contacts', 'Phone'),
                    ],
                    [
                        'name' => 'metaKeys',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('app', 'Meta keys')
                    ],
                    [
                        'name' => 'metaDescription',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('app', 'Meta description')
                    ],
                ],
                'model'         => $model,
                'form'          => $form,
                'languageModel' => new Language()
            ]) ?>

            <?php echo $form->field($model, 'mapQ')->textInput([
                'style' => 'width: 50%;'
            ])->label(Yii::t('contacts', 'Map place')) ?>

            <?php echo $form->field($model, 'mapZoom')->dropDownList(range(0, 100), [
                'style' => 'width: 70px;'
            ])->label(Yii::t('contacts', 'Map zoom')) ?>

            <?php echo $form->field($model, 'default')->checkbox(['value' => 1, 'label' => Yii::t('app', 'Set as default')]) ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->mainModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            [
                'class' => $model->mainModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
