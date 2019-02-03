<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Itstructure\FieldWidgets\TableMultilanguage;
use Itstructure\AdminModule\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Position */

$this->title = $model->getDefaultTranslate('name');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('positions', 'Positions'),
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

<div class="positions-view">

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
                'name' => 'name',
                'label' => Yii::t('positions', 'Name'),
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
