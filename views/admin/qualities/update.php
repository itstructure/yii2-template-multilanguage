<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Quality|app\models\QualityLanguage */
/* @var $aboutList app\models\About[] */

$this->title = Yii::t('qualities', 'Update quality').': ' . $model->title;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('qualities', 'Qualities'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->title,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="qualities-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'aboutList' => $aboutList,
    ]) ?>

</div>
