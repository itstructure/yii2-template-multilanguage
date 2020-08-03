<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $categories array|\yii\db\ActiveRecord[] */

$this->title = Yii::t('categories', 'Create category');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('categories', 'Categories'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
