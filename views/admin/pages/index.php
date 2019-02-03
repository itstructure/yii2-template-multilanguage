<?php

use yii\helpers\Html;
use Itstructure\MultiLevelMenu\MenuWidget;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('pages', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('pages', 'Create page'), [
            $this->params['urlPrefix'].'create'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
    </p>

    <?php echo MenuWidget::widget([
        'data' => $dataProvider->getModels(),
        'itemTemplate' => '@app/views/admin/pages/MultiLevelMenu/index.php',
        'itemTemplateParams' => [
            'urlPrefix' => $this->params['urlPrefix']
        ],
        'mainContainerOptions' => [
            'levels' => [
                ['class' => 'list-group'],
                ['class' => '']
            ]
        ],
        'itemContainerOptions' => [
            'levels' => [
                ['class' => 'list-group-item'],
                ['class' => 'list-group-item list-group-item-success'],
                ['class' => 'list-group-item list-group-item-warning'],
            ]
        ],
    ]) ?>
</div>
