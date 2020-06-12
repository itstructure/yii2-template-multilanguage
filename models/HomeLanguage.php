<?php

namespace app\models;

use Itstructure\AdminModule\models\{Language, ActiveRecord};

/**
 * This is the model class for table "home_language".
 *
 * @property int $home_id
 * @property int $language_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $metaKeys
 * @property string $metaDescription
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Home $home
 * @property Language $language
 *
 * @package app\models
 */
class HomeLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'home_id',
                    'language_id'
                ],
                'required'
            ],
            [
                [
                    'home_id',
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
                    'home_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => ['home_id', 'language_id']
            ],
            [
                [
                    'home_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Home::class,
                'targetAttribute' => ['home_id' => 'id']
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'home_id' => 'Home ID',
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
    public function getHome()
    {
        return $this->hasOne(Home::class, [
            'id' => 'home_id'
        ]);
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
}
