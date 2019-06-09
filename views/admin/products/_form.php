<?php

use yii\data\Pagination;
use yii\helpers\{Html, Url, ArrayHelper};
use yii\widgets\ActiveForm;
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\AdminModule\models\Language;
use Itstructure\MultiLevelMenu\MenuWidget;
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\models\album\Album;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\MFUploader\models\Mediafile;
use yii\bootstrap\Modal;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Product|Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $form yii\widgets\ActiveForm */
/* @var $pages array|\yii\db\ActiveRecord[] */
/* @var $albums Album[] */
/* @var $ownerParams array */
/* @var $images Mediafile[] */
/* @var $media_pages Pagination */
?>

<div class="product-form">

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
                <div class="col-md-12">
                    <?php if(!$model->mainModel->isNewRecord): ?>
                        <?php echo Html::tag('i', '', ['class' => empty($model->mainModel->icon) ? 'fa fa-file fa-2x' : $model->mainModel->icon]) ?>
                    <?php endif; ?>
                    <?php echo Html::a('Fontawesome icons', Url::to('https://fontawesome.ru/all-icons/'), [
                        'target' => '_blank'
                    ]); ?>
                    <?php
                    Modal::begin([
                        'header' => '<h2>Fe icons</h2>',
                        'toggleButton' => ['label' => 'Fe icons']
                    ]);
                    require __DIR__.'/../icons/fe-icons.php';
                    Modal::end();
                    ?>
                </div>
            </div>

            <!-- Thumbnail begin -->
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-6">
                    <?php echo $this->render('../mediafiles/_thumbnail', [
                        'model' => $model,
                        'ownerParams' => isset($ownerParams) && is_array($ownerParams) ? $ownerParams : null,
                    ]) ?>
                </div>
            </div>
            <!-- Thumbnail end -->

            <?php echo $form->field($model, 'active')
                ->radioList([1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')])
                ->label(Yii::t('app', 'Active status')); ?>

            <div class="form-group <?php if ($model->hasErrors('pageId')):?>has-error<?php endif; ?>">
                <?php echo Html::label(Yii::t('products', 'Parent page'), 'parent-pages', [
                    'class' => 'control-label'
                ]) ?>
                <?php echo MenuWidget::widget([
                    'menuId' => 'parent-pages',
                    'data' => $pages,
                    'itemTemplate' => '@app/views/admin/products/MultiLevelMenu/form.php',
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
                <?php if ($model->hasErrors('pageId')):?>
                    <?php foreach ($model->getErrors('pageId') as $error): ?>
                        <div class="help-block"><?php echo $error; ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

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

            <!-- New files begin -->
            <div class="row">
                <div class="col-md-12">
                    <h5><?php echo MFUModule::t('main', 'New files'); ?></h5>
                    <?php for ($i=1; $i < 5; $i++): ?>
                        <?php echo $this->render('../mediafiles/_new-mediafiles', [
                            'model' => $model,
                            'fileType' => UploadModelInterface::FILE_TYPE_IMAGE,
                            'ownerParams' => isset($ownerParams) && is_array($ownerParams) ? $ownerParams : null,
                            'number' => $i,
                        ]) ?>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- New files end -->

            <!-- Existing files begin -->
            <?php if (!$model->isNewRecord): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h5><?php echo MFUModule::t('main', 'Existing files'); ?></h5>
                        <?php echo $this->render('../mediafiles/_existing-mediafiles', [
                            'model' => $model,
                            'mediafiles' => $images,
                            'pages' => $media_pages,
                            'fileType' => UploadModelInterface::FILE_TYPE_IMAGE,
                            'ownerParams' => isset($ownerParams) && is_array($ownerParams) ? $ownerParams : null,
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Existing files end -->
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
