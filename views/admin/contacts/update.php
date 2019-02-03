<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */

$this->title = Yii::t('contacts', 'Update contact').': ' . $model->mainModel->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('contacts', 'Contacts'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->mainModel->getDefaultTranslate('title'),
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contact-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
