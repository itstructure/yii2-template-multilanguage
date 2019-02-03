<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Itstructure\FieldWidgets\TableMultilanguage;
use Itstructure\AdminModule\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = $model->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('contacts', 'Contacts'),
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

<div class="contact-view">

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
                'label' => Yii::t('contacts', 'Title'),
            ],
            [
                'name' => 'address',
                'label' => Yii::t('contacts', 'Address'),
            ],
            [
                'name' => 'email',
                'label' => Yii::t('contacts', 'Email'),
            ],
            [
                'name' => 'phone',
                'label' => Yii::t('contacts', 'Phone'),
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
                'label' => Yii::t('app', 'Default status'),
                'value' => function($model) {
                    /* @var $model app\models\Contact */
                    if ($model->default == 1){
                        return '<i class="fa fa-check-circle text-success"> ' . Yii::t('app', 'Default') . '</i>';
                    } else {
                        return '<i class="fa fa-times text-danger"> ' . Yii::t('app', 'No') . '</i>';
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'mapQ',
                'label' => Yii::t('contacts', 'Map place'),
            ],
            [
                'attribute' => 'mapZoom',
                'label' => Yii::t('contacts', 'Map zoom'),
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
