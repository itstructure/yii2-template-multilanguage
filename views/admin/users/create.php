<?php

/* @var $this yii\web\View */
/* @var $model app\models\UserValidate */
/* @var $roles yii\rbac\Role[] */
/* @var $positions array|\yii\db\ActiveRecord[] */
/* @var $changeRoles bool */

$this->title = Yii::t('users', 'Create user');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('users', 'Users'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'positions' => $positions,
        'changeRoles' => $changeRoles,
    ]) ?>

</div>
