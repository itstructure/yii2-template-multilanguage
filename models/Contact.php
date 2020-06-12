<?php

namespace app\models;

use Itstructure\AdminModule\models\{MultilanguageTrait, Language, ActiveRecord};

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property int $default
 * @property string $created_at
 * @property string $updated_at
 * @property string $mapQ
 * @property int $mapZoom
 *
 * @property ContactLanguage[] $contactsLanguages
 * @property Language[] $languages
 * @property ContactSocial[] $contactSocial
 * @property Social[] $social
 *
 * @package app\models
 */
class Contact extends ActiveRecord
{
    use MultilanguageTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'default',
                    'mapZoom'
                ],
                'integer'
            ],
            [
                'mapQ',
                'string',
                'max' => 255
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
            'default' => 'Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'mapQ' => 'Map place',
            'mapZoom' => 'Map zoom',
        ];
    }

    /**
     * Returns the default contacts record.
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getDefaultContacts()
    {
        return static::find()
            ->where([
                'default' => 1
            ])
            ->one();
    }

    /**
     * Reset the default contacts record.
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
     * @return \yii\db\ActiveQuery
     */
    public function getContactsLanguages()
    {
        return $this->hasMany(ContactLanguage::class, [
            'contacts_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, [
            'id' => 'language_id'
        ])->viaTable('contacts_language', [
            'contacts_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactSocial()
    {
        return $this->hasMany(ContactSocial::class, [
            'contacts_id' => 'id'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocial()
    {
        return $this->hasMany(Social::class, [
            'id' => 'social_id'
        ])->viaTable('contacts_social', [
            'contacts_id' => 'id'
        ]);
    }
}
