<?php
use yii\widgets\LinkPager;
use yii\data\Pagination;
use app\models\{Category, Product};
use app\helpers\BaseHelper;

/* @var Category $model */
/* @var Product[] $products */
/* @var Pagination $pagination */

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

<?php if (count($products) > 0): ?>
    <section class="inform_block">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <?php /* @var Product $product */ ?>
                    <?php foreach ($products as $product): ?>
                        <div class="post">
                            <h2>
                                <span class="<?php echo $product->icon ?>"></span>
                                <a href="<?php echo '/'.$this->params['shortLanguage'].'/product/'.$product->alias ?>" alt="<?php echo $product->{'title_'.$this->params['shortLanguage']} ?>">
                                    <?php echo $product->{'title_'.$this->params['shortLanguage']} ?>
                                </a>
                            </h2>
                            <div class="post_meta"><?php echo Yii::t('products', 'Posted').' '.BaseHelper::getDateAt($product->updated_at) ?></div>
                            <?php echo $product->{'description_'.$this->params['shortLanguage']} ?>
                        </div>
                    <?php endforeach;?>
                    <?php echo LinkPager::widget(['pagination' => $pagination]); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
