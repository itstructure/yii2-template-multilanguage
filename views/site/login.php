<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('site', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="login">
    <div class="container">
        <div class="row">
            <p><?php echo Yii::t('site', 'Please fill out the following fields to login:'); ?></p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]); ?>

            <?php echo $form->field($model, 'login')->textInput(['autofocus' => true])->label(Yii::t('site', 'Login')) ?>

            <?php echo $form->field($model, 'password')->passwordInput()->label(Yii::t('site', 'Password')) ?>

            <?php echo $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-5\">{input} {label}</div>\n<div class=\"col-lg-6\">{error}</div>",
            ])->label(Yii::t('site', 'Remember Me')) ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-5">
                    <?php echo Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <div class="col-lg-6">

                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
