Bizness-develop install ducumentation
==============

1 Introduction
----------------------------

Project is available to install at [Git Lub repository](https://gitlab.com/itstructure/bizness-develop).

2 Dependencies
----------------------------

- php >= 7.1
- composer
- MySql >= 5.5

3 Installation
----------------------------

1. Clone project.
    ```
    SSH SOURCE:
    git@gitlab.com:itstructure/bizness-develop.git
    ```
    ```
    HTTPS SOURCE:
    https://gitlab.com/itstructure/bizness-develop.git
    ```
2. Install dependencies by running from the project root ```composer install```  
3. Create new data base.
4. Copy file ```db_example.php``` to ```db.php```. In file ```db.php``` set the settings according to the settings for accessing the MySql server. Enter the name of the created data base.
5. Run the RBAC migration: 
    ```
    yii migrate --migrationPath=@yii/rbac/migrations
    ```
6. Run multilanguage migration:
    ```
    yii migrate --migrationPath=@admin/migrations/multilanguage
    ```
7. Run MFU module migration:
    ```
    yii migrate --migrationPath=@mfuploader/migrations
    ```
8. Run the application migration:
    ```
    yii migrate
    ```
