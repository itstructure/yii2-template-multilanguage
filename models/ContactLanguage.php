<?php

namespace app\models;

use Yii;
use Itstructure\AdminModule\models\{Language, ActiveRecord};

/**
 * This is the model class for table "contacts_language".
 *
 * @property int $contacts_id
 * @property int $language_id
 * @property string $title
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $metaKeys
 * @property string $metaDescription
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Contact $contacts
 * @property Language $language
 *
 * @package app\models
 */
class ContactLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'contacts_id',
                    'language_id'
                ],
                'required'
            ],
            [
                [
                    'contacts_id',
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
                    'title',
                    'metaKeys',
                    'metaDescription'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'address'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'email'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'phone'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'contacts_id',
                    'language_id'
                ],
                'unique',
                'targetAttribute' => ['contacts_id', 'language_id']
            ],
            [
                [
                    'contacts_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Contact::class,
                'targetAttribute' => ['contacts_id' => 'id']
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contacts_id' => 'Contacts ID',
            'language_id' => 'Language ID',
            'title' => Yii::t('contacts', 'Title'),
            'address' => Yii::t('contacts', 'Address'),
            'email' => Yii::t('contacts', 'Email'),
            'phone' => Yii::t('contacts', 'Phone'),
            'metaKeys' => Yii::t('app', 'Meta keys'),
            'metaDescription' => Yii::t('app', 'Meta description'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasOne(Contact::class, [
            'id' => 'contacts_id'
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
