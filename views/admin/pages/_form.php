<?php

use yii\helpers\{Html, Url, ArrayHelper};
use yii\widgets\ActiveForm;
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\AdminModule\models\Language;
use Itstructure\MultiLevelMenu\MenuWidget;
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\models\album\Album;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Page|Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $form yii\widgets\ActiveForm */
/* @var $pages array|\yii\db\ActiveRecord[] */
/* @var $albums Album[] */
/* @var $ownerParams array */
?>

<div class="catalog-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">

            <?php $this->registerJs("CKEDITOR.plugins.addExternal('pbckcode', '/plugins/pbckcode/plugin.js', '');"); ?>

            <?php echo Fields::widget([
                'fields' => [
                    [
                        'name' => 'title',
                        'type' => FieldType::FIELD_TYPE_TEXT,
                        'label' => Yii::t('app', 'Title')
                    ],
                    [
                        'name' => 'description',
                        'type' => FieldType::FIELD_TYPE_TEXT_AREA,
                        'label' => Yii::t('app', 'Description')
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
                            'extraPlugins' => 'pbckcode',
                            'toolbarGroups' => [
                                ['name' => 'pbckcode']
                            ],
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

            <?php echo $form->field($model, 'icon')->textInput([
                'maxlength' => true,
                'style' => 'width: 25%;'
            ])->label(Yii::t('app', 'Icon html class')); ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-4">
                    <?php if(!$model->mainModel->isNewRecord): ?>
                        <?php echo Html::tag('i', '', ['class' => empty($model->mainModel->icon) ? 'fa fa-file fa-2x' : $model->mainModel->icon]) ?>
                    <?php endif; ?>
                    <?php echo Html::a('Fontawesome icons', Url::to('https://fontawesome.ru/all-icons/'), [
                        'target' => '_blank'
                    ]); ?>
                </div>
            </div>

            <!-- Thumbnail begin -->
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-6">
                    <?php echo $this->render('_thumbnail', [
                        'model' => $model,
                        'ownerParams' => isset($ownerParams) && is_array($ownerParams) ? $ownerParams : null,
                    ]) ?>
                </div>
            </div>
            <!-- Thumbnail end -->

            <?php echo $form->field($model, 'active')
                ->radioList([1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')])
                ->label(Yii::t('app', 'Active status')); ?>

            <?php echo Html::label(Yii::t('app', 'Parent object'), 'multi-level-menu', [
                'class' => 'control-label'
            ]) ?>
            <?php echo MenuWidget::widget([
                'menuId' => 'multi-level-menu',
                'data' => $pages,
                'itemTemplate' => '@app/views/admin/pages/MultiLevelMenu/form.php',
                'itemTemplateParams' => [
                    'model' => $model
                ],
                'mainContainerOptions' => [
                    'levels' => [
                        ['style' => 'margin-left: 0; padding-left: 0;'],
                        ['style' => 'margin-left: 10px; padding-left: 10px;'],
                    ]
                ],
                'itemContainerOptions' => [
                    'style' => 'list-style-type: none;'
                ],
            ]) ?>

            <!-- Albums begin -->
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-6">
                    <?php echo $form->field($model, 'albums')->checkboxList(
                        ArrayHelper::map($albums, 'id', 'title'),
                        [
                            'separator' => '<br />',
                        ]
                    )->label(MFUModule::t('album', 'Albums')); ?>
                </div>
            </div>
            <!-- Albums end -->
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
