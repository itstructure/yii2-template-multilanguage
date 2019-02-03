<?php

/* @var $this yii\web\View */
/* @var $model app\models\UserValidate */
/* @var $roles yii\rbac\Role[] */
/* @var $positions array|\yii\db\ActiveRecord[] */
/* @var $changeRoles bool */

$this->title = Yii::t('users', 'Update user') . ': ' . $model->first_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('users', 'Users'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->first_name,
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
        'positions' => $positions,
        'changeRoles' => $changeRoles,
    ]) ?>

</div>
