<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "login_attempts".
 *
 * @property integer $id
 * @property string $key
 * @property integer $amount
 * @property integer $reset_at
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @package app\models
 */
class LoginAttempt extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_attempts';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'key'
                ],
                'required'
            ],
            [
                [
                    'amount',
                    'reset_at',
                    'updated_at',
                    'created_at'
                ],
                'integer'
            ],
            [
                [
                    'key'
                ],
                'string',
                'max' => 255
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'amount' => 'Amount',
            'reset_at' => 'Reset At',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
