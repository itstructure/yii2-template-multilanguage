<?php

use yii\web\View;
use yii\helpers\{Html, Url};
use yii\widgets\DetailView;
use app\models\User;
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;
use Itstructure\MFUploader\Module as MFUModule;

/* @var $this View */
/* @var $model User|RbacIdentityInterface */

$this->title = Yii::t('users', 'User') . ': ' . $model->first_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('users', 'Users'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <p>
        <?php echo Html::a(Yii::t('app', 'Update'), [
            $this->params['urlPrefix'].'update',
            'id' => $model->id
        ], [
            'class' => 'btn btn-primary'
        ]) ?>

        <?php echo Html::a(Yii::t('app', 'Delete'), [
            $this->params['urlPrefix'].'delete',
            'id' => $model->id
        ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to do this action?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'avatar' => [
                'label' => Yii::t('users', 'Avatar'),
                'value' => function ($model) {
                    /* @var $model User */
                    $thumbnailModel = $model->getThumbnailModel();
                    return $thumbnailModel == null ? '' : Html::a(Html::img($model->getAvatar()), Url::to($thumbnailModel->getThumbUrl(MFUModule::THUMB_ALIAS_LARGE)), [
                        'target' => '_blank'
                    ]);
                },
                'format' => 'raw',
            ],
            'id' => [
                'attribute' => 'id',
                'label' => Yii::t('app', 'ID')
            ],
            'first_name' => [
                'attribute' => 'first_name',
                'label' => Yii::t('users', 'First Name')
            ],
            'last_name' => [
                'attribute' => 'last_name',
                'label' => Yii::t('users', 'Last Name')
            ],
            'patronymic' => [
                'attribute' => 'patronymic',
                'label' => Yii::t('users', 'Patronymic')
            ],
            'login' => [
                'attribute' => 'login',
                'label' => Yii::t('users', 'Login')
            ],
            'email' => [
                'label' => Yii::t('users', 'Email'),
                'value' => function ($model) {
                    return '<a href="mailto:'.$model->email.'">'.$model->email.'</a>';
                },
                'format' => 'raw',
            ],
            'phone' => [
                'attribute' => 'phone',
                'label' => Yii::t('users', 'Phone')
            ],
            'status' => [
                'label' => Yii::t('users', 'Status'),
                'value' => isset($model->status) && !empty($model->status) ? function($data) {
                    if ($data->status == 1){
                        return '<i class="fa fa-check-circle text-success"> ' . Yii::t('app', 'Active') . '</i>';
                    } else {
                        return '<i class="fa fa-times text-danger"> ' . Yii::t('app', 'Blocked') . '</i>';
                    }
                } : Yii::t('users', 'No status'),
                'format' => 'raw',
            ],
            'public' => [
                'label' => Yii::t('users', 'Publicity'),
                'value' => isset($model->public) && !empty($model->public) ? function($data) {
                    if ($data->public == 1){
                        return '<i class="fa fa-folder-open-o text-primary"> ' . Yii::t('app', 'Public') . '</i>';
                    } else {
                        return '<i class="fa fa-minus-circle text-warning"> ' . Yii::t('app', 'Private') . '</i>';
                    }
                } : '<i class="fa fa-minus-circle text-warning"> ' . Yii::t('app', 'Private'),
                'format' => 'raw',
            ],
            'roles' => [
                'attribute' => 'roles',
                'label' => Yii::t('users', 'Roles'),
                'value' => function($model) {
                    /* @var $model RbacIdentityInterface */
                    $roles = $model->getRoles();

                    if (empty($roles)) {return Yii::t('users', 'No roles');}

                    return implode('<br>', array_map(function ($data) {

                        return Html::a($data, Url::to([
                            '/'.$this->params['shortLanguage'].'/rbac/roles/view',
                            'id' => $data
                        ]),
                            [
                                'target' => '_blank'
                            ]);

                    }, array_keys($roles)));
                },
                'format' => 'raw',
            ],
            'position' => [
                'label' => Yii::t('users', 'Position'),
                'value' => function ($model) {
                    /* @var $model \app\models\User */
                    return empty($model->position) ? '' : $model->position->{'name_'.$this->params['shortLanguage']};
                }
            ],
            'about' => [
                'label' => Yii::t('users', 'About'),
                'value' => function ($model) {
                    return $model->about;
                },
                'format' => 'raw',
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Created date')
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Updated date')
            ],
        ]
    ]) ?>

</div>
