<?php

namespace app\models;

use Yii;
use Itstructure\AdminModule\interfaces\ModelInterface;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property int $read
 *
 * @package app\models
 */
class Feedback extends ActiveRecord implements ModelInterface
{
    /**
     * @var string
     */
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'email',
                    'subject',
                    'message',
                ],
                'required'
            ],
            [
                'message',
                'string',
                'max' => 2048
            ],
            [
                [
                    'name',
                    'email'
                ],
                'string',
                'max' => 64
            ],
            [
                'phone',
                'string',
                'max' => 32
            ],
            [
                'subject',
                'string',
                'max' => 255
            ],
            [
                'email',
                'email'
            ],
            [
                'read',
                'integer'
            ],
            [
                [
                    'created_at',
                    'updated_at',
                ],
                'safe',
            ],
            [
                'verifyCode',
                'captcha',
                'captchaAction' => 'contact/captcha'
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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'subject' => 'Subject',
            'message' => 'Message',
            'read' => 'Read',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Returns id of the model.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set read status to "1" after view record.
     *
     * @param int $id
     */
    public static function fixReadStatus(int $id): void
    {
        static::updateAll([
            'read' => 1
        ], [
            'id' => $id
        ]);
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     *
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->save()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject('New message from pack-develop feedback. ' . $this->subject)
                ->setTextBody($this->message)
                ->send();

            return true;
        }

        return false;
    }
}
