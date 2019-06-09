<?php
use yii\data\Pagination;
use Itstructure\MFUploader\models\Mediafile;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\MultilanguageValidateModel */
/* @var $pages array|\yii\db\ActiveRecord[] */
/* @var $albums Itstructure\MFUploader\models\album\Album[] */
/* @var $images Mediafile[] */
/* @var $media_pages Pagination */

$this->title = Yii::t('products', 'Update product').': ' . $model->mainModel->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('products', 'Products'),
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
<div class="product-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'pages' => $pages,
        'albums' => $albums,
        'images' => $images,
        'media_pages' => $media_pages,
        'ownerParams' => [
            'owner' => \app\models\Product::tableName(),
            'ownerId' => $model->getId(),
        ],
    ]) ?>

</div>
