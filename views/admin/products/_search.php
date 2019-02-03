<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Page;
use Itstructure\MultiLevelMenu\MenuWidget;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[role="clear-button"]').on("click", function(e) {
            e.preventDefault();
            $("input[type=radio]").each(function(){
                $(this).prop("checked",false);
            });
            $("input[type=text]").each(function(){
                $(this).prop("value","");
            });
        });
    });
</script>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => [
            $this->params['urlPrefix'].'index'
        ],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'active')
                ->radioList([1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')])
                ->label(Yii::t('app', 'Active status')); ?>

            <?php echo Html::label(Yii::t('products', 'Parent page'), 'search-by-page', [
                'class' => 'control-label'
            ]) ?>
            <?php echo MenuWidget::widget([
                'menuId' => 'search-by-page',
                'data' => Page::getMenu(),
                'itemTemplate' => '@app/views/admin/products/MultiLevelMenu/search.php',
                'itemTemplateParams' => [
                    'model' => $model
                ],
                'mainContainerOptions' => [
                    'levels' => [
                        ['style' => 'margin-left: 0; padding-left: 0;'],
                        ['style' => 'margin-left: 10px; padding-left: 10px;'],
                    ]
                ],
                'itemContainerOptions' => [
                    'style' => 'list-style-type: none;'
                ],
            ]) ?>

            <?php echo $form->field($model, 'title')->label(Yii::t('app', 'Title')) ?>

            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default', 'role' => 'clear-button']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
