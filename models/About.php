<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language};

/**
 * This is the model class for table "about".
 *
 * @property int $id
 * @property int $default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AboutLanguage[] $aboutLanguages
 * @property Language[] $languages
 * @property AboutTechnology[] $aboutTechnologies
 * @property Technology[] $technologies
 * @property AboutQuality[] $aboutQualities
 * @property Quality[] $qualities
 *
 * @package app\models
 */
class About extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about';
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
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id',
            'default',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'default' => 'Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Reset the default about record.
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
     * Returns the default about record.
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getDefaultAbout()
    {
        return static::find()
            ->where([
                'default' => 1
            ])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutLanguages()
    {
        return $this->hasMany(AboutLanguage::class, [
            'about_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('about_language', [
            'about_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutTechnologies()
    {
        return $this->hasMany(AboutTechnology::class, [
            'about_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechnologies()
    {
        return $this->hasMany(Technology::class, [
            'id' => 'technologies_id'
        ])->viaTable('about_technologies', [
            'about_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutQualities()
    {
        return $this->hasMany(AboutQuality::class, [
            'about_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualities()
    {
        return $this->hasMany(Quality::class, [
            'id' => 'qualities_id'
        ])->viaTable('about_qualities', [
            'about_id' => 'id'
        ]);
    }
}
