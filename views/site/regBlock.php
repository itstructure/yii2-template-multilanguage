<?php

/* @var $this yii\web\View */

$this->title = Yii::t('site', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <h2><?php echo Yii::t('site', 'Registration is blocked by the site administrator'); ?></h2>
        <p><img src="/images/regBlock.png" alt="<?php echo Yii::t('site', 'Registration is blocked by the site administrator'); ?>" /></p>
    </div>
</div>
