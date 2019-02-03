<?php
use app\models\{About, Technology};

/* @var $about About */
?>

<div class="container">
    <div class="row">
        <h1><?php echo Yii::t('site', 'Packages development for the frameworks') ?></h1>
    </div>
</div>

<div class="slider_block">
    <div class="flexslider top_slider">
        <ul class="slides">
            <li class="slide1">
                <div class="container">
                    <div class="caption_middle clearfix">
                        <div class="caption_img1 FromLeft"><img src="/images/slider/caption_img1.png" alt="<?php echo Yii::t('slider', 'Modular and container architecture') ?>" /></div>
                        <div class="flex_caption1 FromRight">
                            <p><?php echo Yii::t('slider', 'Modular and container architecture') ?></p>
                            <span><?php echo Yii::t('slider', 'Working out a complex system of related elements') ?></span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="slide2">
                <div class="container">
                    <div class="caption_middle clearfix">
                        <div class="caption_img2 FromTop"><img src="/images/slider/caption_img2.png" alt="<?php echo Yii::t('slider', 'Yii2 modules and components') ?>" /></div>
                        <div class="flex_caption1 FromBottom">
                            <p><?php echo Yii::t('slider', 'Yii2 modules and components') ?></p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="slide2">
                <div class="container">
                    <div class="caption_middle clearfix">
                        <div class="caption_img2 FromTop"><img src="/images/slider/caption_img3.png" alt="<?php echo Yii::t('slider', 'Laravel packages') ?>" /></div>
                        <div class="flex_caption1 FromBottom">
                            <p><?php echo Yii::t('slider', 'Laravel packages') ?></p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<section class="services_block">
    <div class="container">
        <div class="row" data-appear-top-offset="-100" data-animated="fadeInUp">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ss-12 service_item center">
                <a href="javascript:void(0);" >
                    <i class="fe icon_cloud_alt"></i>
                    <p><?php echo Yii::t('features', 'Storage on upsource') ?></p>
                    <span><?php echo Yii::t('features', 'Storage on upsource, such as GITHUB, BITBUCKET') ?></span>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ss-12 service_item center">
                <a href="javascript:void(0);" >
                    <i class="fe icon_tag_alt"></i>
                    <p><?php echo Yii::t('features', 'Fixing releases') ?></p>
                    <span><?php echo Yii::t('features', 'Fixing releases and enhancement') ?></span>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ss-12 service_item center">
                <a href="javascript:void(0);" >
                    <i class="fe icon_puzzle"></i>
                    <p><?php echo Yii::t('features', 'Flexible integration') ?></p>
                    <span><?php echo Yii::t('features', 'Flexible integration with the framework and customization') ?></span>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ss-12 service_item center">
                <a href="javascript:void(0);" >
                    <i class="fe icon_comment_alt"></i>
                    <p><?php echo Yii::t('features', 'Code comments') ?></p>
                    <span><?php echo Yii::t('features', 'Comments on the code and detailed documentation with brief examples') ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="inform_block">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 padbot50" data-appear-top-offset="-100" data-animated="fadeInLeft">
                <?php if (null !== $about && is_array($about->technologies)): ?>
                    <h2><?php echo Yii::t('technologies', 'Technologies') ?></h2>
                    <div class="our-skills">
                        <?php foreach ($about->technologies as $technology): ?>
                            <?php /* @var Technology $technology */ ?>
                            <div class="skill_item">
                                <span><?php echo $technology->name ?></span>
                                <div class="skill-bar" href="javascript:void(0);" alt="">
                                    <div class="progress-complete" data-width="<?php echo $technology->share ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-7 padbot50 about_block" data-appear-top-offset="-100" data-animated="fadeInRight">
                <?php if (null !== $about): ?>
                    <h2><?php echo $about->{'title_'.$this->params['shortLanguage']} ?></h2>
                    <div class="about_block_content">
                        <?php echo $about->{'description_'.$this->params['shortLanguage']} ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
