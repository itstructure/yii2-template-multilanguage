<?php

namespace app\models;

use yii\base\Model;
use app\helpers\InitialUserSettings;

/**
 * Class RegForm
 *
 * @package app\models
 */
class RegForm extends Model
{
    /**
     * Code for captcha.
     *
     * @var string
     */
    public $verifyCode;

    /**
     * Name of user.
     *
     * @var string
     */
    public $first_name;

    /**
     * Login to go in to system.
     *
     * @var string
     */
    public $login;

    /**
     * Email.
     *
     * @var string
     */
    public $email;

    /**
     * Password to go in to system.
     *
     * @var string
     */
    public $password;

    /**
     * Repeat password to go in to system.
     *
     * @var string
     */
    public $passwordRepeat;

    /**
     * User model.
     *
     * @var null
     */
    private $_user = null;

    /**
     * Validate rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'first_name',
                    'login',
                    'email',
                    'password',
                    'passwordRepeat',
                ],
                'filter',
                'filter' => 'trim',
            ],
            [
                [
                    'first_name',
                    'login',
                    'email',
                    'password',
                    'passwordRepeat',
                ],
                'required',
            ],
            [
                [
                    'first_name',
                    'login'
                ],
                'string',
                'min' => 2,
                'max' => 255,
            ],
            [
                [
                    'password',
                    'passwordRepeat',
                ],
                'string',
                'min' => 5,
                'max' => 255,
            ],
            [
                'login',
                'unique',
                'targetClass' => User::class,
                'message' => 'This login already exists.',
            ],
            [
                'email',
                'email',
            ],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message' => 'This email already exists.',
            ],
            [
                'password',
                'compare',
                'compareAttribute' => 'passwordRepeat',
            ],
            [
                'passwordRepeat',
                'compare',
                'compareAttribute' => 'password',
            ],
            [
                'verifyCode',
                'captcha',
                'captchaAction' => 'site/captcha'
            ],
        ];
    }

    /**
     * Attribute labels.
     *
     * @return array
     */
    public function attributeLabels(){

        return[
            'first_name' => 'First name',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'passwordRepeat' => 'Password repeat',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Register user.
     *
     * @return bool
     */
    public function reg()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user = new User();

        $this->_user->first_name = $this->first_name;
        $this->_user->login = $this->login;
        $this->_user->email = $this->email;

        $this->_user->setPassword($this->password);

        if (!$this->_user->save()) {
            return false;
        }

        InitialUserSettings::run($this->_user);

        return true;
    }

    /**
     * Returns user record.
     *
     * @return null|User
     */
    public function getUser()
    {
        return $this->_user;
    }
}
