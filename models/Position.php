<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};

/**
 * This is the model class for table "positions".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PositionLanguage[] $positionsLanguages
 * @property Language[] $languages
 */
class Position extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionsLanguages()
    {
        return $this->hasMany(PositionLanguage::class, [
            'positions_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('positions_language', [
            'positions_id' => 'id'
        ]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getPositions()
    {
        return static::find()
            ->orderBy([
                'id' => SORT_ASC
            ])->all();
    }
}
