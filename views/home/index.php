<?php
use app\models\{About, Technology, Quality, User, Home};
use Itstructure\MFUploader\Module as MFUModule;

$contacts = $this->params['contacts'];

/* @var $about About */
/* @var $team User[] */
/* @var $model Home[] */
?>

<script>
    window.sent_message = '<?php echo Yii::t('feedback', 'You have successfully sent your message.'); ?>';
    window.need_captcha = '<?php echo Yii::t('feedback', 'Let us know that you are not a robot. Click on pictures above.'); ?>';
    window.error_captcha = '<?php echo Yii::t('feedback', 'Error verify captcha.'); ?>';
    window.short_language = '<?php echo $this->params['shortLanguage']; ?>';
</script>

<?php if (!empty($model->{'content_'.$this->params['shortLanguage']})): ?>
    <section class="inform_block">

        <div class="container">

            <div class="row" data-animated="fadeIn">
                <div class="col-lg-12 col-md-12 col-sm-10">
                    <h1 class="text-center"><?php echo $model->{'title_'.$this->params['shortLanguage']}; ?></h1>
                    <?php echo $model->{'content_'.$this->params['shortLanguage']} ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- about section -->
<?php if (null !== $about): ?>
<section id="about">
    <div class="container">
        <div class="row">

            <?php if (is_array($about->qualities)): ?>
                <?php $timeStart = 0.1; ?>
                <?php $timeEnd = 0.5; ?>
                <?php $count = count($about->qualities); ?>
                <?php $timeStep = $count > 1 ? ($timeEnd-$timeStart)/($count-1) : 0; ?>
                <?php $time = $timeStart; ?>
                <?php foreach ($about->qualities as $quality): ?>
                    <?php /* @var Quality $quality */ ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="<?php echo $time; ?>s">
                        <i class="<?php echo $quality->icon ?>"></i>
                        <h3><?php echo $quality->{'title_'.$this->params['shortLanguage']}; ?></h3>
                        <?php echo $quality->{'description_'.$this->params['shortLanguage']}; ?>
                    </div>
                    <?php $time += $timeStep; ?>
                <?php endforeach; ?>
                <div style="clear: both;"></div>
            <?php endif; ?>

            <hr>
            <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <h2 class="text-center"><?php echo $about->{'title_'.$this->params['shortLanguage']}; ?></h2>
                <?php echo $about->{'description_'.$this->params['shortLanguage']}; ?>
            </div>
            <?php if (is_array($about->technologies)): ?>
                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <h2><?php echo Yii::t('technologies', 'Use of technologies') ?></h2>

                    <?php foreach ($about->technologies as $technology): ?>
                        <?php /* @var Technology $technology */ ?>
                        <span class="tech-name"><i class="<?php echo $technology->icon ?>"></i> <?php echo $technology->name ?></span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $technology->share ?>"
                                 aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: <?php echo $technology->share ?>%;"><?php echo $technology->share ?>%
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- team section -->
<?php if (null !== $team && is_array($team) && count($team) > 0): ?>
    <section id="team">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h2><?php echo Yii::t('team', 'Our team') ?></h2>
                </div>

                <?php $timeStart = 0.1; ?>
                <?php $timeEnd = 0.5; ?>
                <?php $count = count($team); ?>
                <?php $timeStep = $count > 1 ? ($timeEnd-$timeStart)/($count-1) : 0; ?>
                <?php $time = $timeStart; ?>
                <?php foreach ($team as $user): ?>
                <?php /* @var User $user */ ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="<?php echo $time; ?>s">
                        <div class="team-wrapper">
                            <?php if ($user->hasAvatar()): ?>
                                <div class="fl-block j-cn">
                                    <a href="<?php echo $user->getThumbnailModel()->getThumbUrl(MFUModule::THUMB_ALIAS_ORIGINAL); ?>" target="_blank" title="<?php echo $user->getFullName() ?>">
                                        <img src="<?php echo $user->getAvatar() ?>" class="img-responsive" alt="<?php echo $user->getFullName() ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="team-des">
                                <div class="team-name"><?php echo $user->getFullName() ?></div>
                                <?php if (!empty($user->position)): ?>
                                    <div class="team-position"><?php echo $user->position->{'name_'.$this->params['shortLanguage']}; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php $time += $timeStep; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- contact section -->
<?php if (null !== $contacts): ?>
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                <h2><?php echo $contacts->{'title_'.$this->params['shortLanguage']} ?></h2>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($contacts->{'phone_'.$this->params['shortLanguage']})): ?>
                <div class="contact-info-box col-md-4 col-sm-4 col-xs-6 wow fadeInUp" data-wow-delay="0.1s">
                    <i class="fa fa-phone"></i>
                    <h3><?php echo $contacts->{'phone_'.$this->params['shortLanguage']} ?></h3>
                </div>
            <?php endif; ?>
            <?php if (!empty($contacts->{'email_'.$this->params['shortLanguage']})): ?>
                <div class="contact-info-box col-md-4 col-sm-4 col-xs-6 wow fadeInUp" data-wow-delay="0.3s">
                    <i class="fa fa-envelope-o"></i>
                    <h3><a href="mailto:<?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?>"><?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?></a></h3>
                </div>
            <?php endif; ?>
            <?php if (!empty($contacts->{'address_'.$this->params['shortLanguage']})): ?>
                <div class="contact-info-box col-md-4 col-sm-4 col-xs-6 wow fadeInUp" data-wow-delay="0.5s">
                    <i class="fa fa-map-marker"></i>
                    <h3><?php echo $contacts->{'address_'.$this->params['shortLanguage']} ?></h3>
                </div>
            <?php endif; ?>
        </div>
        <div class="row" id="feedback" role="feedback">
            <div class="col-md-12 col-sm-12">
                <form action="#" method="post">
                    <div class="col-md-6 col-sm-6">
                        <div data-group="name" class="form-group">
                            <input role="name" type="text" class="form-control" id="name" placeholder="<?php echo Yii::t('feedback', 'Name'); ?>" aria-describedby="help_block_name">
                            <span id="help_block_name" class="help-block"></span>
                        </div>
                        <div data-group="email" class="form-group">
                            <input role="email" type="email" class="form-control" id="email" placeholder="<?php echo Yii::t('feedback', 'Email'); ?>" aria-describedby="help_block_email">
                            <span id="help_block_email" class="help-block"></span>
                        </div>
                        <div data-group="subject" class="form-group">
                            <input role="subject" type="text" class="form-control" id="subject" placeholder="<?php echo Yii::t('feedback', 'Subject'); ?>" aria-describedby="help_block_subject">
                            <span id="help_block_subject" class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div data-group="message" class="form-group">
                            <textarea role="message" rows="7" class="form-control" id="message" placeholder="<?php echo Yii::t('feedback', 'Message'); ?>" aria-describedby="help_block_message"></textarea>
                            <span id="help_block_message" class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 fl-block j-cn a-c">
                        <div class="g-recaptcha" id="google-recaptcha-feedback"
                             data-sitekey="<?php echo !empty(Yii::$app->params['captcha']) ? Yii::$app->params['captcha']['site_key'] : 'test';?>"
                             data-callback="validateRecaptchaFeedback"
                             data-expired-callback="grecaptcha_reset"
                        ></div>
                    </div>
                    <div class="col-md-12 col-sm-12 fl-block j-cn a-c alert-block">
                        <div class="alert nodisplay" role="alert"></div>
                    </div>
                    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-6">
                        <button type="button" role="send" class="form-control" id="submit"><?php echo Yii::t('app', 'Send'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
