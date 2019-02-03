<?php

namespace app\models;

use yii\db\ActiveRecordInterface;
use yii\web\IdentityInterface;
use yii\rbac\ManagerInterface;
use yii\base\{Model, InvalidConfigException};
use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\MFUploader\interfaces\UploadModelInterface;

/**
 * Class for validation user fields.
 *
 * @property string[] $roles
 * @property IdentityInterface|ActiveRecordInterface  $userModel
 * @property ManagerInterface  $authManager
 * @property string  $name
 * @property string  $login
 * @property string  $email
 * @property integer  $status
 * @property string  $password
 * @property string  $passwordRepeat
 *
 * @package app\models
 */
class UserValidate extends Model implements ModelInterface
{
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
     * Scenarios constants.
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

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
                    'name',
                    'login',
                    'email',
                    'status'
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
                    'name',
                    'login',
                    'email',
                    'password',
                    'passwordRepeat',
                ],
                'string',
                'max' => 255,
            ],
            [
                [
                    'status',
                ],
                'integer',
            ],
            [
                'name',
                'unique',
                'skipOnError'     => true,
                'targetClass'     => \Yii::$app->user->identityClass,
                'targetAttribute' => ['name' => 'name'],
                'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
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
            'name',
            'login',
            'email',
            'status',
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
            'name' => 'Name',
            'login' => 'Login',
            'email' => 'Email',
            'status' => 'Status',
            'password' => 'Password',
            'passwordRepeat' => 'Password confirm',
            'roles' => 'Roles',
            UploadModelInterface::FILE_TYPE_THUMB => 'Thumbnail'
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
     *
     * @return void
     */
    private function assignRoles(): void
    {
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
