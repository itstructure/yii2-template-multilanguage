<?php

use yii\helpers\{Url, Html};
use yii\grid\GridView;
use yii\widgets\{LinkPager, ActiveForm};
use app\models\FeedbackSearch;

/* @var $searchModel FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this Itstructure\AdminModule\components\AdminView */

$this->title = Yii::t('feedback', 'Feedback');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>

    <?php $form = ActiveForm::begin([
        'action' => [
            $this->params['urlPrefix'].'delete-selected'
        ],
        'method' => 'post',
    ]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [

                'id',
                'name' => [
                    'label' => Yii::t('feedback', 'Name'),
                    'value' => function($searchModel) {
                        /* @var $searchModel FeedbackSearch */
                        return $searchModel->name;
                    },
                ],
                'email' => [
                    'label' => Yii::t('feedback', 'Email'),
                    'value' => function($searchModel) {
                        /* @var $searchModel FeedbackSearch */
                        return $searchModel->email;
                    },
                ],
                'phone' => [
                    'label' => Yii::t('feedback', 'Phone'),
                    'value' => function($searchModel) {
                        /* @var $searchModel FeedbackSearch */
                        return $searchModel->phone;
                    },
                ],
                'subject' => [
                    'label' => Yii::t('feedback', 'Subject'),
                    'value' => function($searchModel) {
                        /* @var $searchModel FeedbackSearch */
                        return $searchModel->subject;
                    },
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
                'read' => [
                    'label' => Yii::t('feedback', 'Read status'),
                    'value' => function($searchModel) {
                        /* @var $searchModel FeedbackSearch */
                        return $searchModel->read === 1 ?
                            '<i class="fa fa-check-circle text-success"> ' . Yii::t('feedback', 'Read') . '</i>' :
                            '<i class="text-danger">' . Yii::t('feedback', 'New') . '</i>';
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Actions'),
                    'template' => '{view} {delete}',
                    'urlCreator'=>function($action, $model, $key, $index){
                        return Url::to([
                            $this->params['urlPrefix'].$action,
                            'id' => $model->id
                        ]);
                    }
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'header' => Yii::t('app', 'Delete'),
                    'multiple' => true,
                    'name' => Html::getInputName($searchModel, 'delete_items'),
                    'checkboxOptions' => function ($searchModel, $key, $index, $column) use ($form) {
                        return ['form' => $form->id, 'value' => $searchModel->id];
                    }
                ],
            ],
        ]); ?>

    <?php if ($dataProvider->count > 0): ?>
        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('app', 'Delete selected'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
