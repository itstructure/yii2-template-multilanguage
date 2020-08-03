<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $categories array|\yii\db\ActiveRecord[] */

$this->title = Yii::t('categories', 'Update category').': ' . $model->mainModel->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('categories', 'Categories'),
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
<div class="category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
