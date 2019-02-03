<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use app\models\SocialSearch;

/* @var $searchModel SocialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this Itstructure\AdminModule\components\AdminView */

$this->title = Yii::t('social', 'Social');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-index">

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('social', 'Create social'), [
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
                    /* @var $searchModel SocialSearch */
                    return Html::a(
                        Html::tag('i', '', ['class' => $searchModel->icon]),
                        Url::to([$this->params['urlPrefix'].'view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            'url' => [
                'label' => Yii::t('social', 'Url'),
                'value' => function($searchModel) {
                    /* @var $searchModel SocialSearch */
                    return Html::a(
                        Html::encode($searchModel->url),
                        Url::to($searchModel->url),
                        [
                            'target' => '_blank'
                        ]
                    );
                },
                'format' => 'raw',
            ],
            'contacts' => [
                'label' => Yii::t('social', 'Parent contact records'),
                'value' => function ($searchModel) {
                    /* @var $searchModel SocialSearch */
                    $contactRecords = '';
                    foreach ($searchModel->contacts as $contactRecord) {
                        $contactRecords .= Html::tag('li',
                            Html::a($contactRecord->getDefaultTranslate('title'),
                                Url::to(['/'.$this->params['shortLanguage'].'/admin/contact/view', 'id' => $contactRecord->id]),
                                [
                                    'target' => '_blank'
                                ]
                            )
                        );
                    }

                    return empty($contactRecords) ? '' : Html::tag('ul', $contactRecords, [
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
