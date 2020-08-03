<?php

namespace app\components;

use Yii;
use yii\web\Session;
use yii\base\Component;
use yii\db\ActiveRecordInterface;

/**
 * Class BasketComponent
 *
 * @property Session $sessionManager
 *
 * @package app\components
 */
class BasketComponent extends Component
{
    /**
     * Session manager.
     *
     * @var Session
     */
    private $sessionManager;

    /**
     * @var string
     */
    private $containerName = 'basket';

    /**
     * @var string|ActiveRecordInterface
     */
    private $modelClass;

    /**
     * @var string
     */
    private $modelPrimaryKey = 'id';

    /**
     * @var string
     */
    private $modelAmountKey = 'price';

    /**
     * @var array
     */
    private $modelAdditionKeys = [];

    /**
     * @var null|array
     */
    private $sessionData = null;

    /**
     * Initialize.
     */
    public function init()
    {
        if (null === $this->sessionManager) {
            $this->setSessionManager(Yii::$app->session);
        }
    }

    /**
     * Set sessionManager.
     *
     * @param Session $sessionManager
     */
    public function setSessionManager(Session $sessionManager): void
    {
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param string $name
     */
    public function setContainerName(string $name): void
    {
        $this->containerName = $name;
    }

    /**
     * @param string $modelClass
     * @throws \Exception
     */
    public function setModelClass(string $modelClass): void
    {
        $userModelInterfaces = class_implements($modelClass);

        if (!isset($userModelInterfaces[ActiveRecordInterface::class])) {
            throw new \Exception('Model class must be implemented from "'.ActiveRecordInterface::class.'".');
        }

        $this->modelClass = $modelClass;
    }

    /**
     * @param string $modelPrimaryKey
     */
    public function setModelPrimaryKey(string $modelPrimaryKey): void
    {
        $this->modelPrimaryKey = $modelPrimaryKey;
    }

    /**
     * @param string $modelAmountKey
     */
    public function setModelAmountKey(string $modelAmountKey): void
    {
        $this->modelAmountKey = $modelAmountKey;
    }

    /**
     * @param array $modelAdditionKeys
     */
    public function setModelAdditionKeys(array $modelAdditionKeys): void
    {
        $this->modelAdditionKeys = $modelAdditionKeys;
    }

    /**
     * @return mixed
     */
    public function retrieveSessionData()
    {
        if ($this->sessionData == null) {
            $this->sessionData = $this->sessionManager->get($this->containerName);
        }

        return $this->sessionData;
    }

    /**
     * @param array|null $sessionData
     */
    public function fillSessionData(array $sessionData = null): void
    {
        $this->sessionManager->set($this->containerName, $sessionData);

        $this->sessionData = $sessionData;
    }

    /**
     * @param int $modelId
     * @param int $count
     * @return bool
     * @throws \Exception
     */
    public function putToBasket(int $modelId, int $count = 1): bool
    {
        $sessionData = $this->retrieveSessionData();

        if (!empty($sessionData) && !is_array($sessionData)) {
            throw new \Exception('Session data must be an array.');
        }

        if (empty($sessionData)) {
            $sessionData = [
                $modelId => $count
            ];

        } else if (isset($sessionData[$modelId])) {
            $sessionData[$modelId] += $count;

        } else {
            $sessionData[$modelId] = $count;
        }

        $this->fillSessionData($sessionData);

        $result = $this->retrieveSessionData();

        if (empty($result)) {
            throw new \Exception('Session storage is not full.');
        }

        if (!isset($result[$modelId])) {
            throw new \Exception('Order item is not set to storage.');
        }

        return true;
    }

    /**
     * @param int $modelId
     * @param int $count
     * @return bool
     * @throws \Exception
     */
    public function setCountInBasket(int $modelId, int $count): bool
    {
        $sessionData = $this->retrieveSessionData();

        if (empty($sessionData)) {
            throw new \Exception('Session storage is empty.');
        }

        if (!is_array($sessionData)) {
            throw new \Exception('Session data must be an array.');
        }

        if (!isset($sessionData[$modelId])) {
            throw new \Exception('Order item not found in a storage.');
        }

        $sessionData[$modelId] = $count;

        $this->fillSessionData($sessionData);

        return true;
    }

    /**
     * @param int $modelId
     * @return bool
     * @throws \Exception
     */
    public function removeFromBasket(int $modelId): bool
    {
        $sessionData = $this->retrieveSessionData();

        if (empty($sessionData)) {
            throw new \Exception('Session storage is already empty.');
        }

        if (!is_array($sessionData)) {
            throw new \Exception('Session data must be an array.');
        }

        if (!isset($sessionData[$modelId])) {
            throw new \Exception('Order item not found in a storage.');
        }

        if (count($sessionData) > 1) {
            unset($sessionData[$modelId]);
            $this->fillSessionData($sessionData);

        } else {
            $this->clearBasket();
        }

        return true;
    }

    /**
     * Clear basket.
     */
    public function clearBasket(): void
    {
        $this->sessionManager->remove($this->containerName);
        $this->sessionData = null;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        $sessionData = $this->retrieveSessionData();

        if (empty($sessionData)) {
            return 0;
        }

        return array_sum(array_values($sessionData));
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->calculateTotalAmount($this->getModelItems());
    }

    /**
     * @param array $modelItems
     * @return float
     */
    public function calculateTotalAmount(array $modelItems): float
    {
        $sessionData = $this->retrieveSessionData();

        if (empty($sessionData)) {
            return 0;
        }

        $amount = 0;

        foreach ($modelItems as $item) {
            $amount += ($item->{$this->modelAmountKey} * $sessionData[$item->{$this->modelPrimaryKey}]);
        }

        return $amount;
    }

    /**
     * @return array
     */
    public function getModelItems(): array
    {
        $sessionData = $this->retrieveSessionData();

        if (empty($sessionData)) {
            return [];
        }

        $modelClass = $this->modelClass;

        $modelItems = [];
        $selection = [$this->modelPrimaryKey, $this->modelAmountKey];

        foreach ($this->modelAdditionKeys as $additionKey) {
            $selection[] = $additionKey;
        }

        $models = $modelClass::find()->where(['in', $this->modelPrimaryKey, array_keys($sessionData)])->select($selection)->all();

        foreach ($models as $model) {
            $modelItems[$model->{$this->modelPrimaryKey}] = $model;
        }

        return $modelItems;
    }
}
