<?php

use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\{Html, Url};
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
            'name' => [
                'label' => Yii::t('users', 'Name'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->name),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            'email' => [
                'attribute' => 'email',
                'label' =>  Yii::t('users', 'Email'),
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
