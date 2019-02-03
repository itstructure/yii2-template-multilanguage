<?php

use Itstructure\AdminModule\Module as AdminModule;
use Itstructure\RbacModule\Module as RbacModule;

$shortLanguage = $this->view->params['shortLanguage'];

return [
    'menuItems' => [
        'languages' => [
            'title' => AdminModule::t('languages', 'Languages'),
            'icon' => 'fa fa-language',
            'url' => '/'.$shortLanguage.'/admin/languages',
        ],
        'settings' => [
            'title' => Yii::t('settings', 'Settings'),
            'icon' => 'fa fa-cog',
            'url' => '/'.$shortLanguage.'/admin/settings',
        ],
        'users' => [
            'title' => Yii::t('users', 'Users'),
            'icon' => 'fa fa-users',
            'url' => '/'.$shortLanguage.'/admin/users',
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
                ],
                'permissions' => [
                    'title' => RbacModule::t('permissions', 'Permissions'),
                    'icon' => 'fa fa-user-secret',
                    'url' => '/'.$shortLanguage.'/rbac/permissions',
                ],
                'profiles' => [
                    'title' => RbacModule::t('profiles', 'Profiles'),
                    'icon' => 'fa fa-user-o',
                    'url' => '/'.$shortLanguage.'/rbac/profiles',
                ],
            ]
        ],
        'pages' => [
            'title' => Yii::t('pages', 'Pages'),
            'icon' => 'fa fa-file',
            'url' => '/'.$shortLanguage.'/admin/pages',
        ],
        'products' => [
            'title' => Yii::t('products', 'Products'),
            'icon' => 'fa fa-product-hunt',
            'url' => '/'.$shortLanguage.'/admin/products',
        ],
        'feedback' => [
            'title' => Yii::t('feedback', 'Feedback'),
            'icon' => 'fa fa-paper-plane',
            'url' => '/'.$shortLanguage.'/admin/feedback',
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
                ],
                'technologies' => [
                    'title' => Yii::t('about', 'Technologies'),
                    'icon' => 'fa fa-cogs',
                    'url' => '/'.$shortLanguage.'/admin/technologies',
                ],
            ]
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
                ],
                'social' => [
                    'title' => Yii::t('contacts', 'Social'),
                    'icon' => 'fa fa-cogs',
                    'url' => '/'.$shortLanguage.'/admin/social',
                ],
            ]
        ],
        'home' => [
            'title' => Yii::t('home', 'Home page'),
            'icon' => 'fa fa-home',
            'url' => '/'.$shortLanguage.'/admin/home',
        ],
        'sitemap' => [
            'title' => Yii::t('app', 'Sitemap'),
            'icon' => 'fa fa-sitemap',
            'url' => '/'.$shortLanguage.'/admin/sitemap',
        ],
    ],
];
