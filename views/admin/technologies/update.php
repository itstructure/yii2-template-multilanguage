<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Technology */
/* @var $aboutList app\models\About[] */

$this->title = Yii::t('technologies', 'Update technology').': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('technologies', 'Technologies'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="technologies-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'aboutList' => $aboutList,
    ]) ?>

</div>
