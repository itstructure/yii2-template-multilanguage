<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */

$this->title = Yii::t('positions', 'Update position').': ' . $model->mainModel->getDefaultTranslate('name');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('positions', 'Positions'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->mainModel->getDefaultTranslate('name'),
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="positions-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
