<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\web\IdentityInterface;
use yii\rbac\ManagerInterface;
use yii\base\{Model, InvalidConfigException};
use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

/**
 * Class for validation user fields.
 *
 * @property bool $changeRoles
 * @property string[] $roles
 * @property IdentityInterface|ActiveRecordInterface  $userModel
 * @property ManagerInterface  $authManager
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $patronymic
 * @property string  $login
 * @property string  $email
 * @property string  $phone
 * @property integer  $status
 * @property integer  $public
 * @property integer  $position_id
 * @property string  $about
 * @property string  $password
 * @property string  $passwordRepeat
 *
 * @package app\models
 */
class UserValidate extends Model implements ModelInterface
{
    /**
     * Allow to change roles.
     *
     * @var bool
     */
    public $changeRoles = true;

    /**
     * Current profile (user) model.
     *
     * @var IdentityInterface|ActiveRecordInterface
     */
    private $userModel;

    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $authManager;

    /**
     * Initialize.
     */
    public function init()
    {
        if (null === $this->authManager) {
            throw new InvalidConfigException('The authManager is not defined.');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
                    'password',
                    'passwordRepeat',
                ],
                'required',
                'on' => self::SCENARIO_CREATE,
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'patronymic',
                    'login',
                    'email',
                    'phone',
                    'password',
                    'passwordRepeat',
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
                [
                    'status',
                    'public',
                    'position_id',
                ],
                'integer',
            ],
            [
                'login',
                'unique',
                'skipOnError'     => true,
                'targetClass'     => \Yii::$app->user->identityClass,
                'targetAttribute' => ['login' => 'login'],
                'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
            ],
            [
                'email',
                'unique',
                'skipOnError'     => true,
                'targetClass'     => \Yii::$app->user->identityClass,
                'targetAttribute' => ['email' => 'email'],
                'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
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
                'roles',
                'required',
            ],
            [
                'roles',
                'validateRoles',
            ],
            [
                UploadModelInterface::FILE_TYPE_THUMB,
                'integer',
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
     * Scenarios.
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => $this->attributes(),
            self::SCENARIO_UPDATE => $this->attributes(),
            self::SCENARIO_DEFAULT => $this->attributes(),
        ];
    }

    /**
     * List if attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name',
            'last_name',
            'patronymic',
            'position_id',
            'login',
            'email',
            'phone',
            'status',
            'public',
            'about',
            'password',
            'passwordRepeat',
            'roles',
            UploadModelInterface::FILE_TYPE_THUMB,
        ];
    }

    /**
     * List if attribute labels.
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('users', 'First Name'),
            'last_name' => Yii::t('users', 'Last Name'),
            'patronymic' => Yii::t('users', 'Patronymic'),
            'position_id' => Yii::t('users', 'Position'),
            'login' => Yii::t('users', 'Login'),
            'email' => Yii::t('users', 'Email'),
            'phone' => Yii::t('users', 'Phone'),
            'status' => Yii::t('users', 'Status'),
            'public' => Yii::t('users', 'Publicity'),
            'about' => Yii::t('users', 'About'),
            'password' => Yii::t('users', 'Password'),
            'passwordRepeat' => Yii::t('users', 'Password confirm'),
            'roles' => Yii::t('users', 'Roles'),
            UploadModelInterface::FILE_TYPE_THUMB => Yii::t('users', 'Avatar')
        ];
    }

    /**
     * Get field value.
     *
     * @param string $name field name.
     *
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        if ($this->userModel->getIsNewRecord()) {
            return $this->{$name} ?? '';
        }

        return $this->userModel->{$name} ?? '';
    }

    /**
     * Set field value.
     *
     * @param string $name  name of field.
     * @param mixed  $value value to be stored in field.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;

        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->{$name} = $value;
        }
    }

    /**
     * Set new roles values.
     *
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * List of profile assigned roles.
     *
     * @return string[]
     */
    public function getRoles()
    {
        $roles = $this->authManager->getRolesByUser($this->userModel->getId());
        return array_keys($roles);
    }

    /**
     * Set user model.
     *
     * @param IdentityInterface $model.
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function setUserModel(IdentityInterface $model): void
    {
        $this->userModel = $model;
    }

    /**
     * Returns user model.
     *
     * @return IdentityInterface
     */
    public function getUserModel(): IdentityInterface
    {
        return $this->userModel;
    }

    /**
     * Set auth manager.
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Get auth manager.
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Validate roles data format.
     *
     * @param $attribute
     *
     * @return bool
     */
    public function validateRoles($attribute): bool
    {
        if (!is_array($this->roles)) {
            $this->addError($attribute, 'Incorrect roles data format.');
            return false;
        }

        return true;
    }

    /**
     * Save user data.
     *
     * @return bool
     */
    public function save(): bool
    {
        if ($this->userModel->getIsNewRecord()) {
            $this->setScenario(self::SCENARIO_CREATE);
        } else {
            $this->setScenario(self::SCENARIO_UPDATE);
        }

        if (!$this->validate()) {
            return false;
        }

        foreach ($this->attributes() as $attribute) {

            if (null !== $this->{$attribute} && 'roles' !== $attribute) {
                $this->userModel->{$attribute} = $this->{$attribute};
            }
        }

        if (!$this->userModel->save()) {
            return false;
        }

        $this->assignRoles();

        return true;
    }

    /**
     * Returns current model id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->userModel->getId();
    }

    /**
     * Assign roles.
     */
    private function assignRoles()
    {
        if (!$this->changeRoles) {
            return;
        }

        if (!$this->userModel->getIsNewRecord()) {
            $this->authManager->revokeAll(
                $this->userModel->getId()
            );
        }

        foreach ($this->roles as $role) {
            $roleObject = $this->authManager->getRole($role);

            if (null === $roleObject) {
                continue;
            }

            $this->authManager->assign($roleObject, $this->userModel->getId());
        }
    }
}
