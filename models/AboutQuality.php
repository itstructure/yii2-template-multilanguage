<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "about_qualities".
 *
 * @property int $about_id
 * @property int $qualities_id
 *
 * @property About $about
 * @property Quality $quality
 */
class AboutQuality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_qualities';
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
                    'qualities_id'
                ],
                'required'
            ],
            [
                [
                    'about_id',
                    'qualities_id'
                ],
                'integer'
            ],
            [
                [
                    'about_id',
                    'qualities_id'
                ],
                'unique',
                'targetAttribute' => [
                    'about_id',
                    'qualities_id'
                ]
            ],
            [
                [
                    'about_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => About::class,
                'targetAttribute' => [
                    'about_id' => 'id'
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
            'about_id' => 'About ID',
            'qualities_id' => 'Qualities ID',
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
    public function getQuality()
    {
        return $this->hasOne(Quality::class, [
            'id' => 'qualities_id'
        ]);
    }
}
