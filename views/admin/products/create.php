<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $pages array|\yii\db\ActiveRecord[] */

$this->title = Yii::t('products', 'Create product');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('products', 'Products'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="product-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'pages' => $pages,
    ]) ?>

</div>
