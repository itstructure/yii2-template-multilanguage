<?php
use yii\widgets\LinkPager;
use yii\data\Pagination;
use app\models\{Page, Article};
use app\helpers\BaseHelper;

/* @var Page $model */
/* @var Article[] $articles */
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

<?php if (count($articles) > 0): ?>
    <section class="inform_block">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <?php /* @var Article $article */ ?>
                    <?php foreach ($articles as $article): ?>
                        <div class="post">
                            <h2>
                                <span class="<?php echo $article->icon ?>"></span>
                                <a href="<?php echo '/'.$this->params['shortLanguage'].'/article/'.$article->alias ?>" alt="<?php echo $article->{'title_'.$this->params['shortLanguage']} ?>">
                                    <?php echo $article->{'title_'.$this->params['shortLanguage']} ?>
                                </a>
                            </h2>
                            <div class="post_meta"><?php echo Yii::t('articles', 'Posted').' '.BaseHelper::getDateAt($article->updated_at) ?></div>
                            <?php echo $article->{'description_'.$this->params['shortLanguage']} ?>
                        </div>
                    <?php endforeach;?>
                    <?php echo LinkPager::widget(['pagination' => $pagination]); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
