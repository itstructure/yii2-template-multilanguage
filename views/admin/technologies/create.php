<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\Technology */
/* @var $aboutList app\models\About[] */

$this->title = Yii::t('technologies', 'Create technology');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('technologies', 'Technologies'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="technologies-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'aboutList' => $aboutList,
    ]) ?>

</div>
