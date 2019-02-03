<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\AdminModule\models\Language;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\About|Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="about-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php echo Fields::widget([
                'fields' => [
                    [
                        'name' => 'title',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('app', 'Title')
                    ],
                    [
                        'name' => 'description',
                        'type' => FieldType::FIELD_TYPE_CKEDITOR_ADMIN,
                        'label' => Yii::t('app', 'Description'),
                        'preset' => 'full',
                        'options' => [
                            'filebrowserBrowseUrl' => '/ckfinder/ckfinder.html',
                            //'filebrowserImageBrowseUrl' => '/ckfinder/ckfinder.html?type=Images',
                            'filebrowserUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                            'filebrowserImageUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                            'filebrowserWindowWidth' => '1000',
                            'filebrowserWindowHeight' => '300',
                            'allowedContent' => true,
                            'language' => $this->params['shortLanguage'],
                        ]
                    ],
                    [
                        'name' => 'content',
                        'type' => FieldType::FIELD_TYPE_CKEDITOR_ADMIN,
                        'label' => Yii::t('app', 'Content'),
                        'preset' => 'full',
                        'options' => [
                            'filebrowserBrowseUrl' => '/ckfinder/ckfinder.html',
                            //'filebrowserImageBrowseUrl' => '/ckfinder/ckfinder.html?type=Images',
                            'filebrowserUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                            'filebrowserImageUploadUrl' => '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                            'filebrowserWindowWidth' => '1000',
                            'filebrowserWindowHeight' => '700',
                            'allowedContent' => true,
                            'language' => $this->params['shortLanguage'],
                        ]
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
