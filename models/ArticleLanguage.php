<?php

namespace app\models;

use Yii;
use Itstructure\AdminModule\models\{Language, ActiveRecord};

/**
 * This is the model class for table "articles_language".
 *
 * @property int $articles_id
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
 * @property Article $article
 *
 * @package app\models
 */
class ArticleLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'articles_id',
                    'language_id'
                ],
                'required'
            ],
            [
                [
                    'articles_id',
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
                    'articles_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => ['articles_id', 'language_id']
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
                    'articles_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Article::class,
                'targetAttribute' => ['articles_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'articles_id' => 'Article ID',
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
    public function getLanguage()
    {
        return $this->hasOne(Language::class, [
            'id' => 'language_id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, [
            'id' => 'articles_id'
        ]);
    }
}
