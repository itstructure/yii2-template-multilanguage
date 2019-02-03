<?php

namespace app\models;

use Itstructure\AdminModule\models\Language;

/**
 * This is the model class for table "about_language".
 *
 * @property int $about_id
 * @property int $language_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $metaKeys
 * @property string $metaDescription
 * @property string $created_at
 * @property string $updated_at
 *
 * @property About $about
 * @property Language $language
 *
 * @package app\models
 */
class AboutLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'about_id',
                    'language_id',
                ],
                'required'
            ],
            [
                [
                    'about_id',
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
                    'about_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => ['about_id', 'language_id']
            ],
            [
                [
                    'about_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => About::class,
                'targetAttribute' => ['about_id' => 'id']
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
            'about_id' => 'About ID',
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
    public function getAbout()
    {
        return $this->hasOne(About::class, [
            'id' => 'about_id'
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
