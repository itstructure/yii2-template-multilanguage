<?php

namespace app\behaviors;

use Yii;
use yii\base\{Model, Behavior};
use app\models\LoginAttempt;

/**
 * Class LoginAttemptBehavior
 *
 * @package app\behaviors
 */
class LoginAttemptBehavior extends Behavior
{
    /**
     * @var int
     */
    public $attempts = 3;

    /**
     * @var int
     */
    public $duration = 300;

    /**
     * @var int
     */
    public $disableDuration = 900;

    /**
     * @var string
     */
    public $usernameAttribute = 'login';

    /**
     * @var string
     */
    public $passwordAttribute = 'password';

    /**
     * @var string
     */
    public $errorAttribute = 'password';

    /**
     * @var string
     */
    public $message = 'You have exceeded the password attempts.';

    /**
     * @var LoginAttempt
     */
    private $_attempt;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->_attempt = LoginAttempt::find()->where([
            'key' => $this->key
        ])->andWhere([
            '>', 'reset_at', time()
        ])->one();

        if ($this->_attempt) {
            if ($this->_attempt->amount >= $this->attempts) {
                $this->owner->addError($this->errorAttribute, $this->message);
            }

        } else {
            $attempts = LoginAttempt::find()->where([
                'key' => $this->key
            ])->all();

            foreach ($attempts as $attempt) {
                $attempt->delete();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        if ($this->owner->hasErrors($this->passwordAttribute)) {

            if (!$this->_attempt) {
                $this->_attempt = new LoginAttempt;
                $this->_attempt->key = $this->key;
            }

            $this->_attempt->amount += 1;

            if ($this->_attempt->amount >= $this->attempts) {
                $this->_attempt->reset_at = time() + $this->disableDuration;
            } else {
                $this->_attempt->reset_at = time() + $this->duration;
            }

            $this->_attempt->save();
        }
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return sha1($this->owner->{$this->usernameAttribute});
    }
}
