<?php
use yii\helpers\{Url, Html};
use app\helpers\BaseHelper;

/* @var app\models\Category $data */
/* @var string $urlPrefix */
?>
<div class="row">
    <div class="col-md-1">
        <?php echo Html::a(
            Html::tag('i', '', ['class' => empty($data->icon) ? 'fa fa-file fa-2x' : $data->icon]),
            Url::to([$urlPrefix.'view', 'id' => $data->id])
        ) ?>
    </div>
    <div class="col-md-4">
        <?php echo Html::a(
            Html::encode($data->getDefaultTranslate('title')),
            Url::to([$urlPrefix.'view', 'id' => $data->id])
        ) ?>
    </div>
    <div class="col-md-2">
        <?php echo Yii::t('app', 'Created date').' '.BaseHelper::getDateAt($data->created_at) ?>
    </div>
    <div class="col-md-2">
        <?php echo Yii::t('app', 'Updated date').' '.BaseHelper::getDateAt($data->updated_at) ?>
    </div>
    <div class="col-md-2">
        <?php if ($data->active == 1): ?>
            <i class="fa fa-check-circle text-success"> <?php echo Yii::t('app', 'Active'); ?></i>
        <?php else: ?>
            <i class="fa fa-times text-danger"> <?php echo Yii::t('app', 'Inactive'); ?></i>
        <?php endif; ?>
    </div>
    <div class="col-md-1">
        <?php echo Html::a(
            Html::tag('span', '', [
                'class' => 'glyphicon glyphicon-eye-open',
            ]),
            Url::to([$urlPrefix.'view', 'id' => $data->id]),
            [
                'title' => 'View',
                'aria-label' => 'View',
                'data-pjax' => '0'
            ]
        ) ?>
        <?php echo Html::a(
            Html::tag('span', '', [
                'class' => 'glyphicon glyphicon-pencil',
            ]),
            Url::to([$urlPrefix.'update', 'id' => $data->id]),
            [
                'title' => 'Update',
                'aria-label' => 'Update',
                'data-pjax' => '0'
            ]
        ) ?>
        <?php echo Html::a(
            Html::tag('span', '', [
                'class' => 'glyphicon glyphicon-trash',
            ]),
            Url::to([$urlPrefix.'delete', 'id' => $data->id]),
            [
                'title' => 'Delete',
                'aria-label' => 'Delete',
                'data-pjax' => '0',
                'data-confirm' => 'Are you sure you want to delete this item?',
                'data-method' => 'post'
            ]
        ) ?>
    </div>
</div>
