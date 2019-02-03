<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html, Url};
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\widgets\FileSetter;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

/* @var $this yii\web\View */
/* @var $model app\models\UserValidate */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $positions array|\yii\db\ActiveRecord[] */
/* @var $changeRoles bool */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php
            /* @var $userModel app\models\User */
            $userModel = $model->getUserModel();
            echo Html::tag('div', Html::img($userModel->getAvatar()), ['id' => 'thumbnail-container']).
            FileSetter::widget(ArrayHelper::merge([
                        'model' => $model,
                        'attribute' => UploadModelInterface::FILE_TYPE_THUMB,
                        'neededFileType' => UploadModelInterface::FILE_TYPE_THUMB,
                        'buttonName' => MFUModule::t('app', 'Set thumbnail'),
                        'resetButtonName' => MFUModule::t('app', 'Clear'),
                        'options' => [
                            'value' => ($thumbnailModel = $userModel->getThumbnailModel()) !== null ? $thumbnailModel->{FileSetter::INSERTED_DATA_ID} : null,
                        ],
                        'mediafileContainer' => '#thumbnail-container',
                        'subDir' => $userModel->tableName(),
                    ], $userModel->getIsNewRecord() ? ['ownerAttribute' => UploadModelInterface::FILE_TYPE_THUMB] : [
                        'owner' => $userModel->tableName(),
                        'ownerId' => $model->getId(),
                        'ownerAttribute' => UploadModelInterface::FILE_TYPE_THUMB
                ])
            ); ?>

            <?php if (!$changeRoles): ?>
                <div style="margin-bottom: 10px;">
                    <p style="margin: 5px 5px 2px 0; color: red;"><?php echo Yii::t('users', 'Roles'); ?>:</p>
                    <?php foreach ($model->roles as $role): ?>
                        <p style="margin: 2px 5px; color: blue;">
                            <?php echo Html::a($role, Url::to([
                                '/'.$this->params['shortLanguage'].'/rbac/roles/view',
                                'id' => $role
                            ]), [
                                    'target' => '_blank'
                                ]); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php echo Fields::widget([
                    'fields' => [
                        $changeRoles ? [
                            'name' => 'roles',
                            'type' => FieldType::FIELD_TYPE_CHECKBOX,
                            'data' => ArrayHelper::map($roles, 'name', 'name'),
                            'label' => Yii::t('users', 'Roles'),
                        ] : [],
                        [
                            'name' => 'first_name',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'First Name')
                        ],
                        [
                            'name' => 'last_name',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Last Name')
                        ],
                        [
                            'name' => 'patronymic',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Patronymic')
                        ],
                        [
                            'name' => 'position_id',
                            'type' => FieldType::FIELD_TYPE_DROPDOWN,
                            'data' => ArrayHelper::map($positions, 'id', function ($item) {
                                return $item->{'name_'.$this->params['shortLanguage']};
                            }),
                            'label' => Yii::t('users', 'Position')
                        ],
                        [
                            'name' => 'login',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Login')
                        ],
                        [
                            'name' => 'email',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Email')
                        ],
                        [
                            'name' => 'phone',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Phone')
                        ],
                        [
                            'name' => 'status',
                            'type' => FieldType::FIELD_TYPE_DROPDOWN,
                            'data' => [
                                1 => Yii::t('app', 'Active'),
                                0 => Yii::t('app', 'Blocked')
                            ],
                            'label' => Yii::t('users', 'Status'),
                        ],
                        [
                            'name' => 'public',
                            'type' => FieldType::FIELD_TYPE_DROPDOWN,
                            'data' => [
                                1 => Yii::t('app', 'Public'),
                                0 => Yii::t('app', 'Private')
                            ],
                            'label' => Yii::t('users', 'Publicity'),
                        ],
                        [
                            'name' => 'password',
                            'type' => FieldType::FIELD_TYPE_PASSWORD,
                            'label' => Yii::t('users', 'Password')
                        ],
                        [
                            'name' => 'passwordRepeat',
                            'type' => FieldType::FIELD_TYPE_PASSWORD,
                            'label' => Yii::t('users', 'Password confirm')
                        ],
                    ],
                    'model' => $model,
                    'form'  => $form,
                ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php $this->registerJs("CKEDITOR.plugins.addExternal('pbckcode', '/plugins/pbckcode/plugin.js', '');"); ?>

            <?php echo Fields::widget([
                'fields' => [
                    [
                        'name' => 'about',
                        'type' => FieldType::FIELD_TYPE_CKEDITOR_ADMIN,
                        'label' => Yii::t('users', 'About'),
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
                ],
                'model' => $model,
                'form'  => $form,
            ]) ?>
        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
