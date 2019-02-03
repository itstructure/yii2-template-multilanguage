<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $form yii\widgets\ActiveForm */
/* @var string|null $sitemapContent */

$this->title = Yii::t('app', 'Sitemap');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitemap-index">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Export'),
            ['class' => 'btn btn-success']) ?>
    </div>

    <?php if (!empty($sitemapContent)):?>
        <div class="row">
            <div class="col-md-12">
            <pre class="prettyprint linenums" style="height: 500px; overflow-y: scroll;">
                <code class="language-xml"><?php echo $sitemapContent; ?></code>
            </pre>
            </div>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
