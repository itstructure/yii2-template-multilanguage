<?php

use yii\helpers\ArrayHelper;
use app\models\{Page, Category, Article, Product, About, Contact, Home, Quality, Position};
use Itstructure\AdminModule\components\MultilanguageValidateComponent;

$dynamicFieldsMain = [
    'title' => [
        'name' => 'title',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 128,
            ],
            [
                'unique',
            ]
        ]
    ],
    'description' => [
        'name' => 'description',
        'rules' => [
            [
                'string',
            ]
        ]
    ],
    'content' => [
        'name' => 'content',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
            ]
        ]
    ],
];

$descriptionFullRule = [
    'description' => [
        'name' => 'description',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
            ]
        ]
    ],
];

$dynamicFieldsSeo = [
    'metaKeys' => [
        'name' => 'metaKeys',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 128,
            ],
            [
                'unique',
            ]
        ]
    ],
    'metaDescription' => [
        'name' => 'metaDescription',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 255,
            ],
            [
                'unique',
            ]
        ]
    ],
];

$dynamicFieldsContacts = [
    'title' => [
        'name' => 'title',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 128,
            ],
            [
                'unique',
            ]
        ]
    ],
    'address' => [
        'name' => 'address',
        'rules' => [
            [
                'string',
                'max' => 128,
            ]
        ]
    ],
    'email' => [
        'name' => 'email',
        'rules' => [
            [
                'string',
                'max' => 128,
            ]
        ]
    ],
    'phone' => [
        'name' => 'phone',
        'rules' => [
            [
                'string',
                'max' => 128,
            ]
        ]
    ],
];

$dynamicFieldsHome = [
    'title' => [
        'name' => 'title',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 128,
            ],
        ]
    ],
    'description' => [
        'name' => 'description',
        'rules' => [
            [
                'string',
            ]
        ]
    ],
    'content' => [
        'name' => 'content',
        'rules' => [
            [
                'string',
            ]
        ]
    ],
];

$dynamicFieldsQuality = [
    'title' => [
        'name' => 'title',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 128,
            ],
        ]
    ],
    'description' => [
        'name' => 'description',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 1024,
            ]
        ]
    ]
];

$dynamicFieldsPositions = [
    'name' => [
        'name' => 'name',
        'rules' => [
            [
                'required',
            ],
            [
                'string',
                'max' => 64,
            ],
            [
                'unique',
            ]
        ]
    ],
];

return [
    /**
     * Component class.
     */
    'class' => MultilanguageValidateComponent::class,

    /**
     * List of models.
     * Each model is identified by the name of the table.
     * In the config attributes of each model, you need to specify:
     * Dynamic (translated fields) dynamicFields.
     * Field dynamicFields needs to have: 'name' - field name.
     * Field dynamicFields (not necessary) may have 'rules'.
     */
    'models' => [

        /* Page */
        Page::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsMain, $dynamicFieldsSeo),
        ],

        /* Category */
        Category::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsMain, $dynamicFieldsSeo),
        ],

        /* Article */
        Article::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsMain, $dynamicFieldsSeo, $descriptionFullRule),
        ],

        /* Product */
        Product::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsMain, $dynamicFieldsSeo, $descriptionFullRule),
        ],

        /* About */
        About::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsMain, $dynamicFieldsSeo, $descriptionFullRule),
        ],

        /* Contact */
        Contact::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsContacts, $dynamicFieldsSeo),
        ],

        /* Home */
        Home::tableName() => [
            'dynamicFields' => ArrayHelper::merge($dynamicFieldsHome, $dynamicFieldsSeo),
        ],

        /* Quality */
        Quality::tableName() => [
            'dynamicFields' => $dynamicFieldsQuality,
        ],

        /* Position */
        Position::tableName() => [
            'dynamicFields' => $dynamicFieldsPositions,
        ],
    ]
];
