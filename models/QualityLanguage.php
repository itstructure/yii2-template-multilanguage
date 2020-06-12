<?php

namespace app\models;

use Itstructure\AdminModule\models\{Language, ActiveRecord};

/**
 * This is the model class for table "qualities_language".
 *
 * @property int $qualities_id
 * @property int $language_id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Language $language
 * @property Quality $qualities
 */
class QualityLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualities_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'qualities_id',
                    'language_id',
                ],
                'required'
            ],
            [
                [
                    'qualities_id',
                    'language_id'
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
                    'title'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'description'
                ],
                'string',
                'max' => 1024
            ],
            [
                [
                    'qualities_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => [
                    'qualities_id',
                    'language_id'
                ]
            ],
            [
                [
                    'language_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Language::class,
                'targetAttribute' => [
                    'language_id' => 'id'
                ]
            ],
            [
                [
                    'qualities_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Quality::class,
                'targetAttribute' => [
                    'qualities_id' => 'id'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'qualities_id' => 'Qualities ID',
            'language_id' => 'Language ID',
            'title' => 'Title',
            'description' => 'Description',
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
    public function getQualities()
    {
        return $this->hasOne(Quality::class, [
            'id' => 'qualities_id'
        ]);
    }
}
