<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * @package app\models
 */
class Order extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $comment;

    /**
     * @var array
     */
    public $quantity = [];

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
                    'quantity'
                ],
                'required'
            ],
            [
                'quantity',
                'each',
                'rule' => ['integer'],
            ],
            [
                [
                    'name',
                    'email',
                    'phone',
                ],
                'string',
                'max' => 64
            ],
            [
                'comment',
                'string',
                'max' => 2048
            ],
            [
                'email',
                'email'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('order', 'Name'),
            'email' => Yii::t('order', 'Email'),
            'phone' => Yii::t('order', 'Phone'),
            'comment' => Yii::t('order', 'Comment'),
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function handle($email)
    {
        if (!$this->validate()) {
            return false;
        }

        $products = Product::find()->where(['in', 'id', array_keys($this->quantity)])->select(['id', 'alias', 'title', 'price'])->all();

        return Yii::$app->mailer->compose('order', [
            'header' => Yii::t('order', 'New client'),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'comment' => $this->comment,
            'counts' => $this->quantity,
            'products' => $products,
            'baseUrl' => Yii::$app->homeUrl
        ])
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject(Yii::t('order', 'New order in {project_name} site.', ['project_name' => Yii::$app->params['project_name']]))
            ->send();
    }
}
