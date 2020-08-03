<?php

namespace app\models;

use Yii;
use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};

/**
 * This is the model class for table "home".
 *
 * @property int $id
 * @property int $default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property HomeLanguage[] $homeLanguages
 * @property Language[] $languages
 *
 * @package app\models
 */
class Home extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'default'
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'default' => Yii::t('app', 'Default'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
        ];
    }

    /**
     * Reset the default home record.
     *
     * @param boolean $insert
     *
     * @return mixed
     */
    public function beforeSave($insert)
    {
        if ($this->default == 1) {

            $default = static::findOne([
                'default' => 1,
            ]);

            if (null !== $default) {
                $default->default = 0;
                $default->save();
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Returns the default home record.
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getDefaultHome()
    {
        return static::find()
            ->where([
                'default' => 1
            ])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeLanguages()
    {
        return $this->hasMany(HomeLanguage::class, [
            'home_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('home_language', [
            'home_id' => 'id'
        ]);
    }
}
