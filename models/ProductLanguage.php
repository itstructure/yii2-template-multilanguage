<?php

namespace app\models;

use Itstructure\AdminModule\models\Language;

/**
 * This is the model class for table "products_language".
 *
 * @property int $products_id
 * @property int $language_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $metaKeys
 * @property string $metaDescription
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Language $language
 * @property Product $products
 *
 * @package app\models
 */
class ProductLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'products_id',
                    'language_id'
                ],
                'required'
            ],
            [
                [
                    'products_id',
                    'language_id'
                ],
                'integer'
            ],
            [
                [
                    'description',
                    'content'
                ],
                'string'
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
                    'title',
                    'metaKeys',
                    'metaDescription'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'products_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => ['products_id', 'language_id']
            ],
            [
                [
                    'language_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Language::class,
                'targetAttribute' => ['language_id' => 'id']
            ],
            [
                [
                    'products_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['products_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'products_id' => 'Products ID',
            'language_id' => 'Language ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'metaKeys' => 'Meta Keys',
            'metaDescription' => 'Meta Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, [
            'id' => 'language_id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Product::class, [
            'id' => 'products_id'
        ]);
    }
}
