<?php
use app\models\Product;

/* @var Product $model */

$this->params['breadcrumbs'][] = $model->{'title_'.$this->params['shortLanguage']};
?>

<?php if (!empty($model->{'content_'.$this->params['shortLanguage']})): ?>
    <section class="inform_block">

        <div class="container">

            <div class="row" data-animated="fadeIn">
                <div class="col-lg-12 col-md-12 col-sm-10">
                    <?php echo $model->{'content_'.$this->params['shortLanguage']} ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

