<?php

use yii\helpers\ArrayHelper;
use app\models\{Page, Product, About, Contact, Home};
use Itstructure\AdminModule\components\MultilanguageValidateComponent;

$dynamicFieldsMain = [
    'title' => [
        'name' => 'title',
        'rules' => [
            [
                'required',
                'message' => 'Field "{attribute}" must not be empty.'
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
                'message' => 'Field "{attribute}" must not be empty.'
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
                'message' => 'Field "{attribute}" must not be empty.'
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
                'message' => 'Field "{attribute}" must not be empty.'
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
    'metaDescription' => [
        'name' => 'metaDescription',
        'rules' => [
            [
                'required',
                'message' => 'Field "{attribute}" must not be empty.'
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
                'message' => 'Field "{attribute}" must not be empty.'
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
                'max' => 64,
            ]
        ]
    ],
    'phone' => [
        'name' => 'phone',
        'rules' => [
            [
                'string',
                'max' => 32,
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
                'message' => 'Field "{attribute}" must not be empty.'
            ],
            [
                'string',
                'max' => 255,
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
    ]
];
