<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Social */
/* @var $contactList app\models\Contact[] */

$this->title = Yii::t('social', 'Create social');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('social', 'Social'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="social-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'contactList' => $contactList,
    ]) ?>

</div>
