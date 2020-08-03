<?php
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Contact;
use Itstructure\MultiLevelMenu\MenuWidget;

$contacts = $this->params['contacts'];
$controllerId = $this->params['controllerId'];

/* @var \yii\web\View $this */
/* @var string $content */
/* @var Contact $contacts */

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

    <!--<link rel="shortcut icon" href="/images/favicon.ico">-->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php echo $this->render('preloader') ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Yii2 multilanguage project template'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
        ],
    ]); ?>

    <ul class="nav navbar-nav navbar-right">
        <li class="nav-item <?php if($controllerId=='home'): ?>active<?php endif; ?>">
            <a class="nav-link" href="/<?php echo $this->params['shortLanguage']; ?>"><?php echo Yii::t('app', 'Home') ?></a>
        </li>
        <li class="nav-item <?php if($controllerId=='about'): ?>active<?php endif; ?>">
            <a class="nav-link" href="/<?php echo $this->params['shortLanguage']; ?>/about"><?php echo Yii::t('about', 'About') ?></a>
        </li>
        <li class="nav-item dropdown <?php if($controllerId=='page'): ?>active<?php endif; ?>">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo Yii::t('pages', 'Pages') ?>
            </a>
            <?php echo MenuWidget::widget([
                'data' => $this->params['pages'],
                'itemTemplate' => '@app/views/menu/pageItem.php',
                'itemTemplateParams' => function ($level, $item) {
                    return [
                        'shortLanguage' => $this->params['shortLanguage'],
                        'linkOptions' => isset($item['items']) && count($item['items']) > 0 ? [
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            'aria-haspopup' => 'true',
                            'aria-expanded' => 'false',
                        ] : [],
                    ];
                },
                'mainContainerOptions' => [
                    'class' => 'dropdown-menu'
                ],
                'itemContainerOptions' => function ($level, $item) {
                    return [
                        'class' => isset($item['items']) && count($item['items']) > 0 ? 'dropdown-item dropdown' : 'dropdown-item'
                    ];
                }
            ]) ?>
        </li>
        <li class="nav-item dropdown <?php if($controllerId=='category'): ?>active<?php endif; ?>">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo Yii::t('categories', 'Categories') ?>
            </a>
            <?php echo MenuWidget::widget([
                'data' => $this->params['categories'],
                'itemTemplate' => '@app/views/menu/categoryItem.php',
                'itemTemplateParams' => function ($level, $item) {
                    return [
                        'shortLanguage' => $this->params['shortLanguage'],
                        'linkOptions' => isset($item['items']) && count($item['items']) > 0 ? [
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            'aria-haspopup' => 'true',
                            'aria-expanded' => 'false',
                        ] : [],
                    ];
                },
                'mainContainerOptions' => [
                    'class' => 'dropdown-menu'
                ],
                'itemContainerOptions' => function ($level, $item) {
                    return [
                        'class' => isset($item['items']) && count($item['items']) > 0 ? 'dropdown-item dropdown' : 'dropdown-item'
                    ];
                }
            ]) ?>
        </li>
        <li class="nav-item <?php if($controllerId=='contact'): ?>active<?php endif; ?>">
            <a class="nav-link" href="/<?php echo $this->params['shortLanguage']; ?>/contact" ><?php echo Yii::t('contacts', 'Contacts') ?></a>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="dropdown_languages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo Yii::t('site', 'Languages') ?>
            </a>
            <?php echo MenuWidget::widget([
                'data' => $this->params['languages'],
                'itemTemplate' => '@app/views/menu/languageItem.php',
                'mainContainerOptions' => [
                    'class' => 'dropdown-menu',
                    'aria-labelledby' => 'dropdown_languages'
                ],
                'itemContainerOptions' => [
                    'class' => 'dropdown-item'
                ],
            ]) ?>
        </li>
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo Yii::t('site', 'Authorize') ?>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/reg" ><?php echo Yii::t('site', 'Register') ?></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/login" ><?php echo Yii::t('site', 'Login') ?></a>
                    </li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo Yii::t('site', 'Account') ?>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/admin" ><?php echo Yii::t('site', 'Dashboard') ?></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/logout" ><?php echo Yii::t('site', 'Sign out') ?></a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>

    <?php NavBar::end(); ?>

    <div class="container">
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
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row" data-animated="fadeInUp">
            <div class="col-lg-7 col-md-8 col-sm-8 padbot30">
                <ul class="foot_menu">
                    <li <?php if($controllerId=='home'): ?>class="active"<?php endif; ?> >
                        <a href="/<?php echo $this->params['shortLanguage']; ?>" alt=""><?php echo Yii::t('app', 'Home') ?></a>
                    </li>
                    <li <?php if($controllerId=='about'): ?>class="active"<?php endif; ?> >
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/about" ><?php echo Yii::t('about', 'About me') ?></a>
                    </li>
                    <li <?php if($controllerId=='contact'): ?>class="active"<?php endif; ?> >
                        <a href="/<?php echo $this->params['shortLanguage']; ?>/contact" ><?php echo Yii::t('contacts', 'Contacts') ?></a>
                    </li>
                </ul>
                <hr>
                <?php if (null !== $contacts): ?>
                    <ul class="foot_info">
                        <?php if (!empty($contacts->{'address_'.$this->params['shortLanguage']})): ?>
                            <li><i class="fa fa-home"></i><?php echo $contacts->{'address_'.$this->params['shortLanguage']} ?></li>
                        <?php endif; ?>
                        <?php if (!empty($contacts->{'phone_'.$this->params['shortLanguage']})): ?>
                            <li><i class="fa fa-phone"></i><?php echo $contacts->{'phone_'.$this->params['shortLanguage']} ?></li>
                        <?php endif; ?>
                        <?php if (!empty($contacts->{'email_'.$this->params['shortLanguage']})): ?>
                            <li><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?>"><?php echo $contacts->{'email_'.$this->params['shortLanguage']} ?></a></li>
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
                <a class="copyright_logo" href="javascript:void(0);"><?php echo Yii::t('app', 'Yii2 multilanguage project template') ?></a> <span> &copy; Copyright <?php echo date('Y') ?></span>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
