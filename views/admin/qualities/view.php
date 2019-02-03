<?php

use yii\helpers\{Html, Url};
use yii\widgets\DetailView;
use Itstructure\FieldWidgets\TableMultilanguage;
use Itstructure\AdminModule\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Quality|app\models\QualityLanguage */

$this->title = $model->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('qualities', 'Qualities'),
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

<div class="qualities-view">

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

    <h3><?php echo Yii::t('app', 'Translate'); ?></h3>
    <?php echo TableMultilanguage::widget([
        'fields' => [
            [
                'name' => 'title',
                'label' => Yii::t('app', 'Title'),
            ],
            [
                'name' => 'description',
                'label' => Yii::t('app', 'Description'),
            ]
        ],
        'model'         => $model,
        'languageModel' => new Language(),
    ]) ?>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Icon'),
                'value' => function($model) {
                    /* @var $model app\models\Quality */
                    return Html::tag('i', '', ['class' => empty($model->icon) ? 'fa fa-file fa-2x' : $model->icon]);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('qualities', 'Parent about records'),
                'value' => function ($model) {
                    /* @var $model app\models\Quality */
                    $aboutRecords = '';
                    foreach ($model->about as $aboutRecord) {
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
        ],
    ]) ?>

</div>
