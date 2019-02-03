<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */

$this->title = Yii::t('about', 'Create about');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('about', 'About'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="about-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
