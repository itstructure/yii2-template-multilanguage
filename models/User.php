<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\rbac\Role as BaseRole;
use Itstructure\AdminModule\interfaces\AdminMenuInterface;
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;
use Itstructure\MFUploader\behaviors\BehaviorMediafile;
use Itstructure\MFUploader\models\Mediafile;
use Itstructure\MFUploader\interfaces\UploadModelInterface;
use app\traits\ThumbnailTrait;

/**
 * Class User model.
 *
 * @property int $id
 * @property int $order
 * @property int $public
 * @property int $minOrder
 * @property int $maxOrder
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $login
 * @property string $email
 * @property string $phone
 * @property string  $passwordRepeat Password confirmed.
 * @property int|string  $thumbnail Thumbnail(mediafile id or url).
 * @property array|null|\yii\db\ActiveRecord|Mediafile $thumbnailModel
 * @property Position $position
 *
 * @package app\models
 */
class User extends ActiveRecord implements RbacIdentityInterface, AdminMenuInterface
{
    use ThumbnailTrait;

    /**
     * Password confirmed.
     *
     * @var string
     */
    public $passwordRepeat;

    /**
     * Thumbnail(mediafile id or url).
     *
     * @var int|string
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'created_at',
                    'updated_at',
                ],
                'safe',
            ],
            [
                [
                    'first_name',
                    'login',
                    'email',
                ],
                'required',
            ],
            [
                [
                    'status',
                    'public',
                    'order',
                    'position_id',
                ],
                'integer',
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'patronymic',
                    'login',
                    'email',
                    'phone',
                    'hashedPassword',
                ],
                'string',
                'max' => 255,
            ],
            [
                [
                    'about',
                ],
                'string',
            ],
            [
                'login',
                'unique',
            ],
            [
                'email',
                'unique',
            ],
            [
                'email',
                'email',
            ],
            [
                UploadModelInterface::FILE_TYPE_THUMB,
                function($attribute) {
                    if (!is_numeric($this->{$attribute}) && !is_string($this->{$attribute})) {
                        $this->addError($attribute, 'Tumbnail content must be a numeric or string.');
                    }
                },
                'skipOnError' => false,
            ],
            [
                [
                    'position_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Position::class,
                'targetAttribute' => ['position_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'mediafile' => [
                'class' => BehaviorMediafile::class,
                'name' => static::tableName(),
                'attributes' => [
                    UploadModelInterface::FILE_TYPE_THUMB,
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), [
            UploadModelInterface::FILE_TYPE_THUMB,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First name',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'passwordRepeat' => 'Password confirm',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            UploadModelInterface::FILE_TYPE_THUMB => 'Thumbnail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Position
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, [
            'id' => 'position_id'
        ]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getPublicUsers()
    {
        return static::find()
            ->where([
                'public' => 1
            ])->orderBy([
                'order' => SORT_ASC
            ])->all();
    }

    /**
     * Find user by login.
     *
     * @param string $login
     *
     * @return User|null
     */
    public static function findByLogin($login)
    {
        return static::findOne([
            'login' => $login,
        ]);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     *
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     *
     * @param mixed $type  the type of the token. The value of this parameter depends on the
     *                     implementation. For example, [[\yii\filters\auth\HttpBearerAuth]] will
     *                     set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     *
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     *
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     *
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return bool whether the given auth key is valid.
     *
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * Return user's full name.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Return user's name.
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->first_name;
    }

    /**
     * Return role name of user, e.g. "Admin" or "Web Developer"
     *
     * @return string
     */
    public function getRoleName(): string
    {
        return implode(', ', array_keys($this->getRoles()));
    }

    /**
     * List of profile assigned roles.
     *
     * @return BaseRole[]
     */
    public function getRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->getId());
    }

    /**
     * Return the date when user was registered (sign-up).
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return new \DateTime($this->created_at);
    }

    /**
     * Does the user have an avatar.
     *
     * @return boolean
     */
    public function hasAvatar(): bool
    {
        return $this->getThumbnailModel() !== null;
    }

    /**
     * Return a link to avatar image.
     *
     * @return string
     */
    public function getAvatar(): string
    {
        $defaultThumbUrl = $this->getDefaultThumbUrl();

        return empty($defaultThumbUrl) ? '' : $defaultThumbUrl;
    }

    /**
     * Set hashed password.
     *
     * @param string $password.
     *
     * @return $this
     */
    public function setPassword($password)
    {
        if (!empty($password)) {
            $this->hashedPassword = $this->generateHash($password);
        }

        return $this;
    }

    /**
     * Validate password.
     *
     * @param string $password.
     *
     * @return bool.
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()
            ->validatePassword($password, $this->hashedPassword);
    }

    /**
     * @return int
     */
    public function getMinOrder(): int
    {
        $result = static::find()
            ->select('order')
            ->orderBy('order ASC')
            ->one();

        return $result == null ? 1 : $result->order;
    }

    /**
     * @return int
     */
    public function getMaxOrder(): int
    {
        $result = static::find()
            ->select('order')
            ->orderBy('order DESC')
            ->one();

        return $result == null ? 1 : $result->order;
    }

    /**
     * @param int $order
     */
    public function moveOrder(int $order): void
    {
        if ($order == $this->order){
            return;
        }

        /* @var static $future */
        $future = static::find()
            ->where([
                'order' => $order
            ])
            ->one();
        $future->detachBehavior('mediafile');
        $future->order = $order > $this->order ? $order-1 : $order+1;
        $future->save();

        $this->detachBehavior('mediafile');
        $this->order = $order;
        $this->save();
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord){
            $this->order = $this->maxOrder == null ? 1 : $this->maxOrder + 1;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Generate hash by password.
     *
     * @param string $password.
     *
     * @return string
     */
    private function generateHash($password)
    {
        return Yii::$app->getSecurity()
            ->generatePasswordHash($password);
    }
}
