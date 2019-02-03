<?php

use app\components\{
    SettingsComponent,
    UserValidateComponent
};
use app\controllers\admin\{
    PageController,
    ProductController,
    SettingController,
    FeedbackController,
    AboutController,
    TechnologyController,
    ContactController,
    SocialController,
    HomeController,
    LanguageController,
    PermissionController,
    RoleController,
    ProfileController,
    UserController,
    SitemapController
};
use Itstructure\AdminModule\Module as AdminModule;
use Itstructure\RbacModule\Module as RbacModule;
use Itstructure\MFUploader\Module as MFUModule;
use Itstructure\MFUploader\components\LocalUploadComponent;
use Itstructure\MFUploader\controllers\ManagerController;
use Itstructure\MFUploader\controllers\upload\LocalUploadController;

return [
    'modules' => [
        'admin' => [
            'class' => AdminModule::class,
            'viewPath' => '@app/views/admin',
            'controllerMap' => [
                '' => SettingController::class,
                'languages' => LanguageController::class,
                'settings' => SettingController::class,
                'users' => UserController::class,
                'pages' => PageController::class,
                'products' => ProductController::class,
                'feedback' => FeedbackController::class,
                'about' => AboutController::class,
                'technologies' => TechnologyController::class,
                'contacts' => ContactController::class,
                'social' => SocialController::class,
                'home' => HomeController::class,
                'sitemap' => SitemapController::class
            ],
            'accessRoles' => ['admin'],
            'components' => [
                'view' => require __DIR__ . '/view-component.php',
                'multilanguage-validate-component' => require __DIR__ .'/multilanguage-validate-component.php',
            ],
            'isMultilanguage' => true,
        ],
        'rbac' => [
            'class' => RbacModule::class,
            'layout' => '@admin/views/layouts/main-admin.php',
            'controllerMap' => [
                'roles' => RoleController::class,
                'permissions' => PermissionController::class,
                'profiles' => ProfileController::class
            ],
            'accessRoles' => ['admin'],
            'components' => [
                'view' => require __DIR__ . '/view-component.php',
            ],
        ],
        'mfuploader' => [
            'class' => MFUModule::class,
            'layout' => '@admin/views/layouts/main-admin.php',
            'controllerMap' => [
                'upload/local-upload' => LocalUploadController::class,
                'managers' => ManagerController::class,
            ],
            'accessRoles' => ['admin'],
            'components' => [
                'local-upload-component' => [
                    'class' => LocalUploadComponent::class,
                    'checkExtensionByMimeType' => false
                ],
            ],
        ]
    ],
    'components' => [
        'settings' => [
            'class' => SettingsComponent::class
        ],
        'user-validate' => [
            'class' => UserValidateComponent::class
        ],
    ]
];
