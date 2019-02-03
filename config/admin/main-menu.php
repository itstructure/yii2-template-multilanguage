<?php

use Itstructure\AdminModule\Module as AdminModule;
use Itstructure\RbacModule\Module as RbacModule;

$shortLanguage = $this->view->params['shortLanguage'];
$controllerId = Yii::$app->controller->id;

return [
    'menuItems' => [
        'languages' => [
            'title' => AdminModule::t('languages', 'Languages'),
            'icon' => 'fa fa-language',
            'url' => '/'.$shortLanguage.'/admin/languages',
            'active' => $controllerId == 'languages' ? true : false
        ],
        'settings' => [
            'title' => Yii::t('settings', 'Settings'),
            'icon' => 'fa fa-cog',
            'url' => '/'.$shortLanguage.'/admin/settings',
            'active' => $controllerId == 'settings' ? true : false
        ],
        'users' => [
            'title' => Yii::t('users', 'Users'),
            'icon' => 'fa fa-users',
            'url' => '/'.$shortLanguage.'/admin/users',
            'active' => $controllerId == 'users' ? true : false
        ],
        'rbac' => [
            'title' => RbacModule::t('rbac', 'RBAC'),
            'icon' => 'fa fa-universal-access',
            'url' => '#',
            'subItems' => [
                'roles' => [
                    'title' => RbacModule::t('roles', 'Roles'),
                    'icon' => 'fa fa-user-circle-o',
                    'url' => '/'.$shortLanguage.'/rbac/roles',
                    'active' => $controllerId == 'roles' ? true : false
                ],
                'permissions' => [
                    'title' => RbacModule::t('permissions', 'Permissions'),
                    'icon' => 'fa fa-user-secret',
                    'url' => '/'.$shortLanguage.'/rbac/permissions',
                    'active' => $controllerId == 'permissions' ? true : false
                ],
                'profiles' => [
                    'title' => RbacModule::t('profiles', 'Profiles'),
                    'icon' => 'fa fa-user-o',
                    'url' => '/'.$shortLanguage.'/rbac/profiles',
                    'active' => $controllerId == 'profiles' ? true : false
                ],
            ],
            'active' => in_array($controllerId, ['roles', 'permissions', 'profiles']) ? true : false
        ],
        'positions' => [
            'title' => Yii::t('positions', 'Positions'),
            'icon' => 'fa fa-user-circle-o',
            'url' => '/'.$shortLanguage.'/admin/positions',
            'active' => $controllerId == 'positions' ? true : false
        ],
        'pages' => [
            'title' => Yii::t('pages', 'Pages'),
            'icon' => 'fa fa-file',
            'url' => '/'.$shortLanguage.'/admin/pages',
            'active' => $controllerId == 'pages' ? true : false
        ],
        'products' => [
            'title' => Yii::t('products', 'Products'),
            'icon' => 'fa fa-product-hunt',
            'url' => '/'.$shortLanguage.'/admin/products',
            'active' => $controllerId == 'products' ? true : false
        ],
        'feedback' => [
            'title' => Yii::t('feedback', 'Feedback'),
            'icon' => 'fa fa-paper-plane',
            'url' => '/'.$shortLanguage.'/admin/feedback',
            'active' => $controllerId == 'feedback' ? true : false
        ],
        'about' => [
            'title' => Yii::t('about', 'About'),
            'icon' => 'fa fa-info-circle',
            'url' => '#',
            'subItems' => [
                'text' => [
                    'title' => Yii::t('about', 'Text'),
                    'icon' => 'fa fa-file-text',
                    'url' => '/'.$shortLanguage.'/admin/about',
                    'active' => $controllerId == 'about' ? true : false
                ],
                'technologies' => [
                    'title' => Yii::t('about', 'Technologies'),
                    'icon' => 'fa fa-cogs',
                    'url' => '/'.$shortLanguage.'/admin/technologies',
                    'active' => $controllerId == 'technologies' ? true : false
                ],
                'qualities' => [
                    'title' => Yii::t('about', 'Qualities'),
                    'icon' => 'fa fa-cogs',
                    'url' => '/'.$shortLanguage.'/admin/qualities',
                    'active' => $controllerId == 'qualities' ? true : false
                ],
            ],
            'active' => in_array($controllerId, ['about', 'technologies', 'qualities']) ? true : false
        ],
        'contacts' => [
            'title' => Yii::t('contacts', 'Contacts'),
            'icon' => 'fa fa-location-arrow',
            'url' => '#',
            'subItems' => [
                'text' => [
                    'title' => Yii::t('contacts', 'Text'),
                    'icon' => 'fa fa-file-text',
                    'url' => '/'.$shortLanguage.'/admin/contacts',
                    'active' => $controllerId == 'contacts' ? true : false
                ],
                'social' => [
                    'title' => Yii::t('contacts', 'Social'),
                    'icon' => 'fa fa-cogs',
                    'url' => '/'.$shortLanguage.'/admin/social',
                    'active' => $controllerId == 'social' ? true : false
                ],
            ],
            'active' => in_array($controllerId, ['contacts', 'social']) ? true : false
        ],
        'home' => [
            'title' => Yii::t('home', 'Home page'),
            'icon' => 'fa fa-home',
            'url' => '/'.$shortLanguage.'/admin/home',
            'active' => $controllerId == 'home' ? true : false
        ],
        'sitemap' => [
            'title' => Yii::t('app', 'Sitemap'),
            'icon' => 'fa fa-sitemap',
            'url' => '/'.$shortLanguage.'/admin/sitemap',
            'active' => $controllerId == 'sitemap' ? true : false
        ],
    ],
];
