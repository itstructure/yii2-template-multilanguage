<?php

namespace app\models;

/**
 * This is the model class for table "about_technologies".
 *
 * @property int $about_id
 * @property int $technologies_id
 *
 * @property About $about
 * @property Technology $technology
 *
 * @package app\models
 */
class AboutTechnology extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_technologies';
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
                    'technologies_id'
                ],
                'required'
            ],
            [
                [
                    'about_id',
                    'technologies_id'
                ],
                'integer'
            ],
            [
                [
                    'about_id',
                    'technologies_id'
                ],
                'unique',
                'targetAttribute' => ['about_id', 'technologies_id']
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
                    'technologies_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Technology::class,
                'targetAttribute' => ['technologies_id' => 'id']
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
            'technologies_id' => 'Technologies ID',
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
    public function getTechnology()
    {
        return $this->hasOne(Technology::class, [
            'id' => 'technologies_id'
        ]);
    }
}
