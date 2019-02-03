<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */

$this->title = Yii::t('contacts', 'Create contact');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('contacts', 'Contacts'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="contact-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
