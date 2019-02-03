<?php

use yii\web\View;
use yii\helpers\{Html, Url};
use yii\widgets\DetailView;
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;

/* @var $this View */
/* @var $model RbacIdentityInterface */

$this->title = Yii::t('users', 'User') . ': ' . $model->name;
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
            'id' => [
                'attribute' => 'id',
                'label' => Yii::t('app', 'ID')
            ],
            'name' => [
                'attribute' => 'name',
                'label' => Yii::t('users', 'Name')
            ],
            'login' => [
                'attribute' => 'login',
                'label' => Yii::t('users', 'Login')
            ],
            'email' => [
                'attribute' => 'email',
                'label' => Yii::t('users', 'Email')
            ],
            'status' => [
                'attribute' => 'status',
                'label' => Yii::t('users', 'Status'),
                'value' => isset($model->status) && !empty($model->status) ? function($data) {
                    return $data->status == 1 ? Yii::t('app', 'Active') : Yii::t('app', 'Blocked');
                } : Yii::t('users', 'No status'),
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
