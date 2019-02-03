<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\widgets\FileSetter;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

/* @var $this yii\web\View */
/* @var $model app\models\UserValidate */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles yii\rbac\Role[] */
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

            <?php echo Fields::widget([
                    'fields' => [
                        [
                            'name' => 'roles',
                            'type' => FieldType::FIELD_TYPE_CHECKBOX,
                            'data' => ArrayHelper::map($roles, 'name', 'name'),
                            'label' => Yii::t('users', 'Roles')
                        ],
                        [
                            'name' => 'name',
                            'type' => FieldType::FIELD_TYPE_TEXT,
                            'label' => Yii::t('users', 'Name')
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
                            'name' => 'status',
                            'type' => FieldType::FIELD_TYPE_DROPDOWN,
                            'data' => [
                                1 => Yii::t('app', 'Active'),
                                0 => Yii::t('app', 'Blocked')
                            ],
                            'label' => Yii::t('users', 'Status'),
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


    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
