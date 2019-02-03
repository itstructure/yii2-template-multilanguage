<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use Itstructure\FieldWidgets\TableMultilanguage;
use Itstructure\AdminModule\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $albumsDataProvider yii\data\ArrayDataProvider */

$this->title = $model->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('pages', 'Pages'),
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

<div class="page-view">

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
            ],
            [
                'name' => 'content',
                'label' => Yii::t('app', 'Content'),
            ],
            [
                'name' => 'metaKeys',
                'label' => Yii::t('app', 'Meta keys'),
            ],
            [
                'name' => 'metaDescription',
                'label' => Yii::t('app', 'Meta description'),
            ],
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
                    /* @var $model app\models\Page */
                    return Html::tag('i', '', ['class' => empty($model->icon) ? 'fa fa-file fa-2x' : $model->icon]);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('app', 'Active status'),
                'value' => function($model) {
                    /* @var $model app\models\Page */
                    if ($model->active == 1){
                        return '<i class="fa fa-check-circle text-success"> ' . Yii::t('app', 'Active') . '</i>';
                    } else {
                        return '<i class="fa fa-times text-danger"> ' . Yii::t('app', 'Inactive') . '</i>';
                    }
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

    <?php echo Html::a(Yii::t('pages', 'View products'), [
        '/'.$this->params['shortLanguage'].'/admin/products/index', 'ProductSearch[pageId]' => $model->id
    ], [
        'class' => 'btn btn-primary'
    ]) ?>

</div>
