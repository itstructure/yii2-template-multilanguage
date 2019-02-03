<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegForm */

$this->title = Yii::t('site', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <p><?php echo Yii::t('site', 'Please fill out the following fields to register:'); ?></p>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?php echo $form->field($model, 'name')->textInput(['autofocus' => true])->label(Yii::t('site', 'Name')) ?>

        <?php echo $form->field($model, 'email')->textInput()->label(Yii::t('site', 'Email')) ?>

        <?php echo $form->field($model, 'login')->textInput()->label(Yii::t('site', 'Login')) ?>

        <?php echo $form->field($model, 'password')->passwordInput()->label(Yii::t('site', 'Password')) ?>

        <?php echo $form->field($model, 'passwordRepeat')->passwordInput()->label(Yii::t('site', 'Password repeat')) ?>

        <?php echo $form->field($model, 'verifyCode')->widget(Captcha::class, [
            'captchaAction' => '/'.$this->params['shortLanguage'].'/site/captcha',
            'template' => '<div class="row"><div class="col-lg-7">{image}</div></div>
                            <div class="row"><div class="col-lg-12">{input}</div></div>',
        ])->label(Yii::t('feedback', 'Verify code')) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?php echo Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
