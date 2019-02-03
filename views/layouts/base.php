<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Contact;
use Itstructure\MultiLevelMenu\MenuWidget;

/* @var \yii\web\View $this */
/* @var string $content */
/* @var Contact $contacts */

$contacts = $this->params['contacts'];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <title><?php echo Html::encode($this->title); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo Html::csrfMetaTags(); ?>

    <link rel="shortcut icon" href="/images/favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="preloader"><img src="/images/preloader.gif" alt="" /></div>

<div id="page">

    <div class="preloader_hide">

        <div class="page_block">

            <header>
                <div class="menu_block clearfix">

                    <div class="container clearfix">

                        <div class="logo">
                            <a href="/<?php echo $this->params['shortLanguage']; ?>" ><?php echo Yii::t('app', 'Pack Develop') ?></a>
                        </div>

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <em></em><em></em><em></em><em></em>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="first active"><a href="/<?php echo $this->params['shortLanguage']; ?>" ><?php echo Yii::t('app', 'Home') ?></a></li>
                                <li class="first"><a href="/<?php echo $this->params['shortLanguage']; ?>/about" ><?php echo Yii::t('about', 'About me') ?></a></li>
                                <li class="sub-menu menu_middle"><a href="javascript:void(0);" ><?php echo Yii::t('site', 'Development') ?></a>
                                    <?php echo MenuWidget::widget([
                                        'data' => $this->params['pages'],
                                        'itemTemplate' => '@app/views/menu/pageItem.php',
                                        'itemTemplateParams' => [
                                            'shortLanguage' => $this->params['shortLanguage']
                                        ],
                                    ]) ?>
                                </li>
                                <li class="sub-menu"><a href="/<?php echo $this->params['shortLanguage']; ?>/contact" ><?php echo Yii::t('contacts', 'Contacts') ?></a></li>
                                <li class="sub-menu"><a href="javascript:void(0);" ><?php echo Yii::t('site', 'Languages') ?></a>
                                    <?php echo MenuWidget::widget([
                                        'data' => $this->params['languages'],
                                        'itemTemplate' => '@app/views/menu/languageItem.php',
                                    ]) ?>
                                </li>
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <li class="sub-menu"><a href="javascript:void(0);" ><?php echo Yii::t('site', 'Authorize') ?></a>
                                        <ul>
                                            <li><a href="/<?php echo $this->params['shortLanguage']; ?>/reg" ><?php echo Yii::t('site', 'Register') ?></a></li>
                                            <li><a href="/<?php echo $this->params['shortLanguage']; ?>/login" ><?php echo Yii::t('site', 'Login') ?></a></li>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li class="sub-menu"><a href="javascript:void(0);" ><?php echo Yii::t('site', 'Account') ?></a>
                                        <ul>
                                            <li><a href="/<?php echo $this->params['shortLanguage']; ?>/admin" ><?php echo Yii::t('site', 'Dashboard') ?></a></li>
                                            <li><a href="/<?php echo $this->params['shortLanguage']; ?>/logout" ><?php echo Yii::t('site', 'Sign out') ?></a></li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <?php if (isset($this->params['breadcrumbs'])): ?>
                <section class="full_width breadcrumbs_block clearfix">
                    <div class="container">
                        <div class="breadcrumbs_content">
                            <h1 class="pull-left"><?php echo Html::encode($this->title) ?></h1>
                            <?php echo Breadcrumbs::widget([
                                'tag' => 'ol',
                                'options' => [
                                    'class' => 'pull-right breadcrumb'
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'homeLink' => [
                                    'label' => Yii::t('yii', 'Home'),
                                    'url' => rtrim(Yii::$app->homeUrl, '/') . '/' . $this->params['shortLanguage'],
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    <div class="overlay_black"></div>
                </section>
            <?php endif; ?>

            <?php echo $content ?>

            <footer class="full_width footer_block">
                <div class="container">
                    <div class="row" data-animated="fadeInUp">
                        <div class="col-lg-7 col-md-8 col-sm-8 padbot30">
                            <ul class="foot_menu">
                                <li class="active"><a href="/<?php echo $this->params['shortLanguage']; ?>" alt=""><?php echo Yii::t('app', 'Home') ?></a></li>
                                <li><a href="/<?php echo $this->params['shortLanguage']; ?>/about" ><?php echo Yii::t('about', 'About me') ?></a></li>
                                <li><a href="/<?php echo $this->params['shortLanguage']; ?>/contact" ><?php echo Yii::t('contacts', 'Contacts') ?></a></li>
                            </ul>
                            <hr>
                            <?php if (null !== $contacts): ?>
                                <ul class="foot_info">
                                    <?php if (!empty($contacts->{'address_'.$this->params['shortLanguage']})): ?>
                                        <li><i class="fe icon_house"></i><?php echo $contacts->{'address_'.$this->params['shortLanguage']} ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($contacts->{'phone_'.$this->params['shortLanguage']})): ?>
                                        <li><i class="fe icon_phone"></i><?php echo $contacts->{'phone_'.$this->params['shortLanguage']} ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($contacts->{'email_'.$this->params['shortLanguage']})): ?>
                                        <li><i class="fe icon_mail"></i><a href="mailto:<?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?>"><?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 padbot30 pull-right foot_social_block">
                            <?php if (null !== $contacts && is_array($contacts->social)): ?>
                                <h2><?php echo Yii::t('social', 'Social') ?></h2>
                                <hr>
                                <div class="social">
                                    <?php foreach ($contacts->social as $social): ?>
                                        <a href="<?php echo $social->url ?>" target="_blank" ><i class="<?php echo $social->icon ?>"></i></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="copyright clearfix">
                    <div class="container">
                        <div class="padbot20">
                            <a class="copyright_logo" href="javascript:void(0);"><?php echo Yii::t('app', 'Pack Develop') ?></a> <span> &copy; Copyright 2018</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
