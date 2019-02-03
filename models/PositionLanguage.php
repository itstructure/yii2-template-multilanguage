<?php

namespace app\models;

use Itstructure\AdminModule\models\Language;

/**
 * This is the model class for table "positions_language".
 *
 * @property int $positions_id
 * @property int $language_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Language $language
 * @property Position $positions
 */
class PositionLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'positions_id',
                    'language_id'
                ],
                'required'
            ],
            [
                [
                    'positions_id',
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
                    'name'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'positions_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => [
                    'positions_id',
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
                    'positions_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Position::class,
                'targetAttribute' => [
                    'positions_id' => 'id'
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
            'positions_id' => 'Positions ID',
            'language_id' => 'Language ID',
            'name' => 'Name',
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
    public function getPositions()
    {
        return $this->hasOne(Position::class, [
            'id' => 'positions_id'
        ]);
    }
}
