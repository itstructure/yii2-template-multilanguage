<?php

use Itstructure\AdminModule\components\AdminView;

return [
    'class' => AdminView::class,
    'skin' => AdminView::SKIN_GREEN_LIGHT,
    'bodyLayout' => AdminView::LAYOUT_SIDEBAR_MINI,
    //'mainMenuConfig' => require __DIR__ . '/main-menu.php',
    'companyName' => 'Bizness develop',
    'shotCompanyName' => 'BIZ',
    'extraAssets' => require __DIR__ . '/extra-assets.php',
];
