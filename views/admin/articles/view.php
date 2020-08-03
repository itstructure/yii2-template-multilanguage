<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\{ArrayDataProvider, Pagination};
use Itstructure\FieldWidgets\TableMultilanguage;
use Itstructure\AdminModule\models\Language;
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\models\album\Album;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use Itstructure\MFUploader\models\Mediafile;
use app\models\Article;

/* @var $this yii\web\View */
/* @var $model Article */
/* @var $images array */
/* @var $images_items Mediafile[] */
/* @var $images_pagination Pagination */

$images_items = $images['items'];
$images_pagination = $images['pagination'];

$this->title = $model->getDefaultTranslate('title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('articles', 'Articles'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    h5 {
        font-weight: bold;
        padding: 5px;
    }
</style>

<div class="article-view">

    <p>
        <?php echo Html::a(Yii::t('app', 'Update'), [
            $this->params['urlPrefix'].'update',
            'id' => $model->id
        ], [
            'class' => 'btn btn-primary'
        ]) ?>

        <?php echo Html::a(Yii::t('app', 'Delete'), [
            $this->params['urlPrefix'].'delete',
            'id' => $model->id
        ], [
            'class' => 'btn btn-danger',
            'data'=>[
                'method' => 'post',
                'confirm' => Yii::t('app', 'Are you sure you want to do this action?'),
            ]
        ]) ?>
    </p>

    <h3><?php echo Yii::t('app', 'Translate'); ?></h3>
    <?php echo TableMultilanguage::widget([
        'fields' => [
            [
                'name' => 'title',
                'label' => Yii::t('app', 'Title'),
            ],
            [
                'name' => 'description',
                'label' => Yii::t('app', 'Description'),
            ],
            [
                'name' => 'content',
                'label' => Yii::t('app', 'Content'),
            ],
            [
                'name' => 'metaKeys',
                'label' => Yii::t('app', 'Meta keys'),
            ],
            [
                'name' => 'metaDescription',
                'label' => Yii::t('app', 'Meta description'),
            ],
        ],
        'model'         => $model,
        'languageModel' => new Language(),
    ]) ?>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'thumbnail' => [
                'label' => MFUModule::t('main', 'Thumbnail'),
                'value' => function ($model) {
                    /* @var $model Article */
                    $thumbnailModel = $model->getThumbnailModel();
                    return $thumbnailModel == null ? '' : Html::a($model->getDefaultThumbImage(), Url::to($thumbnailModel->getThumbUrl(MFUModule::THUMB_ALIAS_LARGE)), [
                        'target' => '_blank'
                    ]);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('app', 'Icon'),
                'value' => function($model) {
                    /* @var $model Article */
                    return Html::tag('i', '', ['class' => empty($model->icon) ? 'fa fa-file fa-2x' : $model->icon]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'alias',
                'label' => Yii::t('app', 'URL Alias'),
            ],
            [
                'label' => Yii::t('app', 'Active status'),
                'value' => function($model) {
                    /* @var $model Article */
                    if ($model->active == 1){
                        return '<i class="fa fa-check-circle text-success"> ' . Yii::t('app', 'Active') . '</i>';
                    } else {
                        return '<i class="fa fa-times text-danger"> ' . Yii::t('app', 'Inactive') . '</i>';
                    }
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('articles', 'Parent page'),
                'value' => function ($model) {
                    /* @var $model Article */
                    return null === $model->page ? '' : Html::a(
                        $model->page->getDefaultTranslate('title'),
                        Url::to(['/'.$this->params['shortLanguage'].'/admin/pages/view', 'id' => $model->page->id]),
                        [
                            'target' => '_blank'
                        ]
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Created date'),
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                'label' => Yii::t('app', 'Updated date'),
            ],
        ],
    ]) ?>

    <!-- Existing files begin -->
    <?php if ($images_pagination->totalCount > 0): ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo MFUModule::t('main', 'Existing files'); ?></div>
            <div class="panel-body">
                <?php echo $this->render('../mediafiles/_existing-mediafiles', [
                    'edition' => false,
                    'mediafiles' => $images_items,
                    'pages' => $images_pagination,
                    'fileType' => UploadModelInterface::FILE_TYPE_IMAGE,
                ]) ?>
            </div>
        </div>
    <?php endif; ?>
    <!-- Existing files end -->

    <?php if (count($albums = $model->getAlbums()) > 0): ?>
        <h3><?php echo MFUModule::t('album', 'Albums') ?></h3>
        <?php echo GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $albums
            ]),
            'columns' => [
                'thumbnail' => [
                    'label' => MFUModule::t('main', 'Thumbnail'),
                    'value' => function($item) {
                        /** @var Album $item */
                        return Html::a(
                            $item->getDefaultThumbImage(),
                            Url::to([
                                '/'.$this->params['shortLanguage'].'/mfuploader/'.$item->getFileType($item->type).'-album/view', 'id' => $item->id
                            ])
                        );
                    },
                    'format' => 'raw',
                ],
                'name' => [
                    'label' => MFUModule::t('album', 'Title'),
                    'value' => function($item) {
                        /** @var Album $item */
                        return Html::a(
                            Html::encode($item->title),
                            Url::to([
                                '/'.$this->params['shortLanguage'].'/mfuploader/'.$item->getFileType($item->type).'-album/view', 'id' => $item->id
                            ])
                        );
                    },
                    'format' => 'raw',
                ],
                'description' => [
                    'label' => MFUModule::t('album', 'Description'),
                    'value' => function($item) {
                        /** @var Album $item */
                        return $item->description;
                    },
                ],
            ],
        ]); ?>
    <?php endif; ?>

</div>
