<?php

namespace app\models;

use Yii;
use Itstructure\AdminModule\models\{Language, ActiveRecord};

/**
 * This is the model class for table "pages_language".
 *
 * @property integer $pages_id
 * @property integer $language_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $metaKeys
 * @property string $metaDescription
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Page $page
 * @property Language $language
 *
 * @package app\models
 */
class PageLanguage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'pages_id',
                    'language_id',
                ],
                'required',
            ],
            [
                [
                    'pages_id',
                    'language_id',
                ],
                'integer',
            ],
            [
                [
                    'description',
                    'content',
                ],
                'string',
            ],
            [
                [
                    'created_at',
                    'updated_at',
                ],
                'safe',
            ],
            [
                [
                    'title',
                    'metaKeys',
                    'metaDescription',
                ],
                'string',
                'max' => 255,
            ],
            [
                ['pages_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Page::class,
                'targetAttribute' => ['pages_id' => 'id'],
            ],
            [
                ['language_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Language::class,
                'targetAttribute' => ['language_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pages_id' => 'Page ID',
            'language_id' => 'Language ID',
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'metaKeys' => Yii::t('app', 'Meta keys'),
            'metaDescription' => Yii::t('app', 'Meta description'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, [
            'id' => 'pages_id'
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
