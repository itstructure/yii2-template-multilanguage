<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use app\models\QualitySearch;

/* @var $searchModel QualitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this Itstructure\AdminModule\components\AdminView */

$this->title = Yii::t('qualities', 'Qualities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qualities-index">

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('qualities', 'Create quality'), [
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
            'icon' => [
                'label' => Yii::t('app', 'Icon'),
                'value' => function($searchModel) {
                    /* @var $searchModel QualitySearch */
                    return Html::a(
                        Html::tag('i', '', ['class' => empty($searchModel->icon) ? 'fa fa-file fa-2x' : $searchModel->icon]),
                        Url::to([$this->params['urlPrefix'].'view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            'title' => [
                'label' => Yii::t('app', 'Title'),
                'value' => function($searchModel) {
                    /* @var $searchModel QualitySearch */
                    return Html::a(
                        Html::encode($searchModel->getDefaultTranslate('title')),
                        Url::to([$this->params['urlPrefix'].'view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            'about' => [
                'label' => Yii::t('qualities', 'Parent about records'),
                'value' => function ($searchModel) {
                    /* @var $searchModel QualitySearch */
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
