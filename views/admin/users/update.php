<?php

/* @var $this yii\web\View */
/* @var $model app\models\UserValidate */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('users', 'Update user') . ': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('users', 'Users'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>
