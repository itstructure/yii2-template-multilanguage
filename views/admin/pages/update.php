<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $pages array|\yii\db\ActiveRecord[] */
/* @var $albums Itstructure\MFUploader\models\album\Album[] */
/* @var $images array */

$this->title = Yii::t('pages', 'Update page').': ' . $model->mainModel->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('pages', 'Pages'),
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
<div class="page-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'pages' => $pages,
        'albums' => $albums,
        'images' => $images,
        'ownerParams' => [
            'owner' => \app\models\Page::tableName(),
            'ownerId' => $model->getId(),
        ],
    ]) ?>

</div>
