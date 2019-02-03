<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('feedback', 'Feedback'),
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

<div class="feedback-view">

    <p>
        <?php echo Html::a(Yii::t('app', 'Delete'), [
            $this->params['urlPrefix'].'delete', 'id' => $model->id
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
                'label' => Yii::t('feedback', 'Name'),
                'value' => function($model) {
                    /* @var $model app\models\Feedback */
                    return $model->name;
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('feedback', 'Email'),
                'value' => function($model) {
                    /* @var $model app\models\Feedback */
                    return $model->email;
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('feedback', 'Phone'),
                'value' => function($model) {
                    /* @var $model app\models\Feedback */
                    return $model->phone;
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('feedback', 'Subject'),
                'value' => $model->subject,
            ],
            [
                'label' => Yii::t('feedback', 'Message'),
                'value' => $model->message,
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
