<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */

$this->title = Yii::t('home', 'Create home page');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('home', 'Home page'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="home-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
