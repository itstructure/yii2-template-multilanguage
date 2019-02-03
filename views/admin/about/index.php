<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use app\models\AboutSearch;

/* @var $searchModel AboutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this Itstructure\AdminModule\components\AdminView */

$this->title = Yii::t('about', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-index">

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('about', 'Create about'), [
            $this->params['urlPrefix'].'create'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [

            'id',
            'title' => [
                'label' => Yii::t('app', 'Title'),
                'value' => function($searchModel) {
                    /* @var $searchModel AboutSearch */
                    return Html::a(
                        Html::encode($searchModel->getDefaultTranslate('title')),
                        Url::to([$this->params['urlPrefix'].'view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            'description' => [
                'label' => Yii::t('app', 'Description'),
                'value' => function($searchModel) {
                    /* @var $searchModel AboutSearch */
                    return $searchModel->getDefaultTranslate('description');
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Created date'),
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Updated date'),
            ],
            'default' => [
                'label' => Yii::t('app', 'Default status'),
                'value' => function($searchModel) {
                    /* @var $searchModel AboutSearch */
                    if ($searchModel->default === 1) {
                        return Html::tag('i', '', [
                            'class' => 'fa fa-check-circle',
                        ]);
                    }

                    return Html::a(Yii::t('app', 'Set as default'), Url::to([
                        'set-default',
                        'aboutId' => $searchModel->id,
                    ]), [
                        'title' => Yii::t('app', 'Set as default'),
                    ]);
                },
                'format' => 'raw',
            ],
            [
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
        ],
    ]); ?>
</div>
