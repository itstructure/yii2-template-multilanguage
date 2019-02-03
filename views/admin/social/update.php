<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Social */
/* @var $contactList app\models\Contact[] */

$this->title = Yii::t('social', 'Update social').': ' . $model->url;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('social', 'Social'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->url,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="social-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'contactList' => $contactList,
    ]) ?>

</div>
