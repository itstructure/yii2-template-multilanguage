<?php

use yii\helpers\{Html, Url};
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Social */

$this->title = $model->url;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('social', 'Social'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    h5 {
        font-weight: bold;
        padding: 5px;
    }
</style>

<div class="social-view">

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
            'data'=>[
                'method' => 'post',
                'confirm' => Yii::t('app', 'Are you sure you want to do this action?'),
            ]
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Icon'),
                'value' => function ($model) {
                    /* @var $model app\models\Social */
                    return Html::tag('i', '', ['class' => $model->icon]);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('social', 'Url'),
                'value' => function ($model) {
                    /* @var $model app\models\Social */
                    return Html::a(
                        Html::encode($model->url),
                        Url::to($model->url),
                        [
                            'target' => '_blank'
                        ]
                    );
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('social', 'Parent contact records'),
                'value' => function ($model) {
                    /* @var $model app\models\Social */
                    $contactRecords = '';
                    foreach ($model->contacts as $contactRecord) {
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
        ],
    ]) ?>

</div>
