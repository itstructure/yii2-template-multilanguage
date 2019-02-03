<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language};

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $pageId
 * @property string $icon
 * @property int $active
 *
 * @property Page $page
 * @property ProductLanguage[] $productsLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Product extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'pageId',
                    'active'
                ],
                'required'
            ],
            [
                [
                    'pageId',
                    'active'
                ],
                'integer'
            ],
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ],
            [
                [
                    'icon'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'pageId'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Page::class,
                'targetAttribute' => ['pageId' => 'id']
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id',
            'pageId',
            'icon',
            'active',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pageId' => 'Page ID',
            'icon' => 'Icon',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, [
            'id' => 'pageId'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsLanguages()
    {
        return $this->hasMany(ProductLanguage::class, [
            'products_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('products_language', [
            'products_id' => 'id'
        ]);
    }
}
