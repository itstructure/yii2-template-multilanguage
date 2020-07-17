Yii2 template multilanguage install documentation
==============

[![Build Status](https://scrutinizer-ci.com/g/itstructure/yii2-template-multilanguage/badges/build.png?b=master)](https://scrutinizer-ci.com/g/itstructure/yii2-template-multilanguage/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itstructure/yii2-template-multilanguage/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/itstructure/yii2-template-multilanguage/?branch=master)

1 Introduction
----------------------------

Yii2 project template with multilanguage mode, based on [Yii2 basic framework](https://github.com/yiisoft/yii2-app-basic).

Project is available to install at [Git Hub repository](https://github.com/itstructure/yii2-template-multilanguage).

This template includes:

- Admin panel, based on [AdminLTE](https://github.com/almasaeed2010/AdminLTE)

- Ability to content manage with some number of languages.

- Number of entities, which are managed by admin panel:
    - Languages
    - Site settings (Initial role and status after registration, e.t.c.)
    - Users
    - RBAC (Set roles and permissions for users)
    - Positions
    - Pages
        - Products (child products for pages)
    - Feedback
    - About (about company page)
        - Technologies (child)
        - Qualities (child)
    - Contacts
        - Social (child)
    - Home page
    - Site map
    
This template helps you to easy start your Yii2 project. And then you can change it as you wish.

2 Requirements
----------------------------

- php >= 7.1
- composer
- MySql >= 5.5

3 Installation
----------------------------

1. Clone project.

    `SSH SOURCE: git@github.com:itstructure/yii2-template-multilanguage.git`
    
    `HTTPS SOURCE: https://github.com/itstructure/yii2-template-multilanguage.git`
    
2. Install dependencies by running from the project root `composer install`

3. Copy file `config/base-url_example.php` to `config/base-url.php`. In file `config/base-url.php` set a project host:

    ```php
    return YII_DEBUG ? 'http://dev-example-host' : 'http://prod-example-host';
    ```

4. Create new data base.

5. Copy file `config/db_example.php` to `config/db.php`. In file `config/db.php` set settings according with the access to MySql server.

    Example:
    
    ```php
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=yourdbname',
        'username' => 'root',
        'password' => 'passwordvalue',
        'charset' => 'utf8',
    ];
    ```

6. Run the RBAC migration:

    `yii migrate --migrationPath=@yii/rbac/migrations`
    
7. Run the command to build initial rbac entities:

    `yii build-rbac`
    
    Roles and permissions will be created with the following structure:
    
        |--------------------|-----------------------------|
        |                    |            Roles            |
        |                    |-----------------------------|
        | Permissions        |  admin  | manager |  user   |
        |--------------------|---------|---------|---------|
        | CREATE             |    X    |         |         |
        | UPDATE             |    X    |         |         |
        | DELETE             |    X    |         |         |
        | SET_ROLES          |    X    |         |         |
        | VIEW_BACKSIDE      |    X    |    X    |         |
        | VIEW_FRONTSIDE     |    X    |    X    |    X    |
        |--------------------|---------|---------|---------|
    
8. Run multilanguage migration:

    `yii migrate --migrationPath=@admin/migrations/multilanguage`
    
9. Run MFU module migration:

    `yii migrate --migrationPath=@mfuploader/migrations`
    
10. Run the application migration:

    `yii migrate`
    
11. If you are going to use google captcha, copy file `config/captcha_example.php` to `config/captcha.php`. In file `config/captcha.php` it is necessary to set captcha params:

    ```php
    return [
        'site_key' => 'your-google-site-key',
        'secret_key' => 'your-google-secret-key',
    ];
    ```
    
    And uncomment `captcha` option in `config/params.php` config file.
    
12. If you are going to load some files to Amazon S3 remote storage by [MFUploader module](https://github.com/itstructure/yii2-multi-format-uploader), it is necessary to set AWS access params in new `config/aws-credentials.php` config file.
    
    Copy file `config/aws-credentials_example.php` to `config/aws-credentials.php` and set:
        
    ```php
    return [
        'key' => 'your-aws-s3-key',
        'secret' => 'your-aws-s3-secret',
    ];
    ```
    
    And uncomment `s3-upload-component` option of the `mfuploader` module option in `config/admin/admin.php` config file.
    
    Comment or delete `local-upload-component` option.
    
    Then set `'defaultStorageType' => MFUModule::STORAGE_TYPE_S3`