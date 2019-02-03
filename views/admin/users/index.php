<?php

use yii\grid\GridView;
use yii\helpers\{Html, Url};
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\UserSearch */
/* @var $administrateAccess bool */

$this->title = Yii::t('users', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('users', 'Create user'), [
            $this->params['urlPrefix'].'create'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id' => [
                'label' => Yii::t('app', 'ID'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->id),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            'avatar' => [
                'label' => Yii::t('users', 'Avatar'),
                'value' => function ($searchModel) {
                    /* @var $searchModel \app\models\UserSearch */
                    $thumbnailModel = $searchModel->getThumbnailModel();
                    return $thumbnailModel == null ? '' : Html::a(Html::img($searchModel->getAvatar(), [
                            'width' => 75,
                            'height' => 75,
                        ]), Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            'first_name' => [
                'label' => Yii::t('users', 'First Name'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->first_name),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            'last_name' => [
                'label' => Yii::t('users', 'Last Name'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->last_name),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            'status' => [
                'label' => Yii::t('users', 'Status'),
                'value' => function($searchModel) {
                    if (!isset($searchModel->status) || empty($searchModel->status)) {
                        return '<i class="fa fa-minus-circle text-warning"> ' . Yii::t('users', 'No status');
                    }
                    if ($searchModel->status == 1){
                        return '<i class="fa fa-check-circle text-success"> ' . Yii::t('app', 'Active') . '</i>';
                    } else {
                        return '<i class="fa fa-times text-danger"> ' . Yii::t('app', 'Blocked') . '</i>';
                    }
                },
                'format' => 'raw',
            ],
            'public' => [
                'label' => Yii::t('users', 'Publicity'),
                'value' => function($searchModel) {
                    if (!isset($searchModel->public) || empty($searchModel->public)) {
                        return '<i class="fa fa-minus-circle text-warning"> ' . Yii::t('app', 'Private');
                    }
                    if ($searchModel->public == 1){
                        return '<i class="fa fa-folder-open-o text-primary"> ' . Yii::t('app', 'Public') . '</i>';
                    } else {
                        return '<i class="fa fa-minus-circle text-warning"> ' . Yii::t('app', 'Private') . '</i>';
                    }
                },
                'format' => 'raw',
            ],
            'email' => [
                'label' =>  Yii::t('users', 'Email'),
                'value' => function ($model) {
                    return '<a href="mailto:'.$model->email.'">'.$model->email.'</a>';
                },
                'format' => 'raw',
            ],
            'roles' => [
                'label' => Yii::t('users', 'Roles'),
                'value' => function($searchModel) {
                    /* @var $searchModel RbacIdentityInterface */
                    $roles = $searchModel->getRoles();

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
                'attribute' => 'position',
                'label' =>  Yii::t('users', 'Position'),
                'value' => function ($searchModel) {
                    /* @var $searchModel \app\models\UserSearch */
                    return empty($searchModel->position) ? '' : $searchModel->position->{'name_'.$this->params['shortLanguage']};
                }
            ],
            'sort' => [
                'label' => Yii::t('users', 'Order'),
                'value' => function($searchModel) {
                    return
                        Html::tag('div',
                            $searchModel->order > $searchModel->minOrder ?
                                Html::a(Html::tag('i', '', ['class' => 'fa fa-sort-asc fa-lg', 'aria-hidden' => true]),
                                    Url::to(['/'.$this->params['shortLanguage'].'/admin/users', 'id' => $searchModel->id, 'order' => $searchModel->order - 1])
                                ) : ''
                            ,
                            [
                                'style' => 'clear:both;'
                            ]
                        )
                        .
                        Html::tag('div',
                            $searchModel->order < $searchModel->maxOrder ?
                                Html::a(Html::tag('i', '', ['class' => 'fa fa-sort-desc fa-lg', 'aria-hidden' => true]),
                                    Url::to(['/'.$this->params['shortLanguage'].'/admin/users', 'id' => $searchModel->id, 'order' => $searchModel->order + 1])
                                ) : ''
                            ,
                            [
                                'style' => 'clear:both;'
                            ]
                        )
                        .
                        ($searchModel->minOrder == $searchModel->maxOrder ?
                            '-' : ''
                        );
                },
                'format' => 'raw',
                'visible' => $administrateAccess
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'label' => Yii::t('app', 'Created date'),
                'format' =>  ['date', 'dd.MM.YY HH:mm:ss'],
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'label' => Yii::t('app', 'Updated date'),
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
            ],
            'ActionColumn' => [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Actions'),
                'template' => '{view} {update} {delete}',
                'urlCreator'=>function($action, $model, $key, $index){
                    return Url::to([
                        $this->params['urlPrefix'].$action,
                        'id' => $model->id
                    ]);
                }
            ],
        ]
    ]); ?>
</div>
