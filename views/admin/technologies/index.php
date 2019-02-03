<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use app\models\TechnologySearch;

/* @var $searchModel TechnologySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this Itstructure\AdminModule\components\AdminView */

$this->title = Yii::t('technologies', 'Technologies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technologies-index">

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('technologies', 'Create technology'), [
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
            'name' => [
                'label' => Yii::t('technologies', 'Name'),
                'value' => function($searchModel) {
                    /* @var $searchModel TechnologySearch */
                    return Html::a(
                        Html::encode($searchModel->name),
                        Url::to([$this->params['urlPrefix'].'view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'share',
                'label' => Yii::t('technologies', 'Share'),
            ],
            'about' => [
                'label' => Yii::t('technologies', 'Parent about records'),
                'value' => function ($searchModel) {
                    /* @var $searchModel TechnologySearch */
                    $aboutRecords = '';
                    foreach ($searchModel->about as $aboutRecord) {
                        $aboutRecords .= Html::tag('li',
                            Html::a($aboutRecord->getDefaultTranslate('title'),
                                Url::to(['/'.$this->params['shortLanguage'].'/admin/about/view', 'id' => $aboutRecord->id]),
                                [
                                    'target' => '_blank'
                                ]
                            )
                        );
                    }

                    return empty($aboutRecords) ? '' : Html::tag('ul', $aboutRecords, [
                        'style' => 'margin-left: 10px; padding-left: 10px;'
                    ]);
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
