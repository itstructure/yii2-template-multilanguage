<?php

namespace app\models;

/**
 * This is the model class for table "contacts_social".
 *
 * @property int $contacts_id
 * @property int $social_id
 *
 * @property Contact $contacts
 * @property Social $social
 *
 * @package app\models
 */
class ContactSocial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts_social';
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
                    'social_id'
                ],
                'required'
            ],
            [
                [
                    'contacts_id',
                    'social_id'
                ],
                'integer'
            ],
            [
                [
                    'contacts_id',
                    'social_id'
                ],
                'unique',
                'targetAttribute' => ['contacts_id', 'social_id']
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
                    'social_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Social::class,
                'targetAttribute' => ['social_id' => 'id']
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
            'social_id' => 'Social ID',
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
    public function getSocial()
    {
        return $this->hasOne(Social::class, [
            'id' => 'social_id'
        ]);
    }
}
