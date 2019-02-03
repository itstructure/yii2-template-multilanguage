<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Quality */
/* @var $aboutList app\models\About[] */

$this->title = Yii::t('qualities', 'Create quality');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('qualities', 'Qualities'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="qualities-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'aboutList' => $aboutList,
    ]) ?>

</div>
