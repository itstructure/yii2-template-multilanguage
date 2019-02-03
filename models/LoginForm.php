<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\behaviors\LoginAttemptBehavior;

/**
 * Class LoginForm
 *
 * @package app\models
 */
class LoginForm extends Model
{
    /**
     * Login to go in to system.
     *
     * @var string
     */
    public $login;

    /**
     * Password to go in to system.
     *
     * @var string
     */
    public $password;

    /**
     * Use cookie to remember user in browser.
     *
     * @var bool
     */
    public $rememberMe = true;

    /**
     * User model.
     *
     * @var null
     */
    private $_user = null;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'login',
                    'password',
                ],
                'required',
            ],
            [
                'rememberMe',
                'boolean',
            ],
            [
                'password',
                'validatePassword',
            ],
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

                'attempts' => [

                    'class' => LoginAttemptBehavior::class,

                    // Amount of attempts in the given time period
                    'attempts' => 3,
                ]
            ]
        );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (null === $user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }
}
