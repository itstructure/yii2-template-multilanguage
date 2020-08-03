<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $pages array|\yii\db\ActiveRecord[] */
/* @var $albums Itstructure\MFUploader\models\album\Album[] */

$this->title = Yii::t('articles', 'Create article');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('articles', 'Articles'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="article-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'pages' => $pages,
        'albums' => $albums,
    ]) ?>

</div>
