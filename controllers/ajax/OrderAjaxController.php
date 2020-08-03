<?php

namespace app\controllers\ajax;

use Yii;
use yii\filters\{ContentNegotiator, VerbFilter};
use yii\web\{Controller, Response, BadRequestHttpException};
use app\traits\ResponseTrait;
use app\components\BasketComponent;
use app\models\Order;

/**
 * Class OrderAjaxController
 *
 * @package app\controllers
 */
class OrderAjaxController extends Controller
{
    use ResponseTrait;

    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'yii\rest\Serializer';

    /**
     * @var BasketComponent
     */
    protected $basketManager;

    /**
     * Initialize.
     */
    public function init()
    {
        parent::init();

        $this->basketManager = Yii::$app->get('basket');
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $this->serializeData($result);
    }

    /**
     * @return array
     */
    public function verbs()
    {
        return [
            'put-to-basket' => ['POST'],
            'set-count-in-basket' => ['POST'],
            'remove-from-basket' => ['POST'],
            'send-order' => ['POST'],
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionPutToBasket()
    {
        try {
            $id = Yii::$app->request->post('id');
            $count = Yii::$app->request->post('count');

            if ($this->basketManager->putToBasket($id, empty($count) ? 1 : $count)) {
                return $this->getSuccessResponse('', [
                    'total_amount' => $this->basketManager->getTotalAmount(),
                    'total_count' => $this->basketManager->getTotalCount(),
                ]);
            }

            return $this->getFailResponse('Failed put to basket');

        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionSetCountInBasket()
    {
        try {
            $id = Yii::$app->request->post('id');
            $count = Yii::$app->request->post('count');

            if ($this->basketManager->setCountInBasket($id, $count)) {
                $modelItems = $this->basketManager->getModelItems();

                return $this->getSuccessResponse('', [
                    'total_amount' => $this->basketManager->calculateTotalAmount($modelItems),
                    'total_count' => $this->basketManager->getTotalCount(),
                    'item_price' => $modelItems[$id]->price
                ]);
            }

            return $this->getFailResponse('Failed set count in a basket');

        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionRemoveFromBasket()
    {
        try {
            $id = Yii::$app->request->post('id');

            if ($this->basketManager->removeFromBasket($id)) {
                return $this->getSuccessResponse('', [
                    'total_amount' => $this->basketManager->getTotalAmount(),
                    'total_count' => $this->basketManager->getTotalCount(),
                ]);
            }

            return $this->getFailResponse('Failed remove from basket');

        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionSendOrder()
    {
        try {
            $order = new Order();
            $order->setAttributes(Yii::$app->request->post(), false);

            if ($order->handle(Yii::$app->params['adminEmail'])) {
                $this->basketManager->clearBasket();
                return $this->getSuccessResponse(Yii::t('order', 'You have successfully sent your order message.').' '.Yii::t('order', 'The manager will contact you.'));

            } else {
                return $this->getFailResponse(Yii::t('feedback', 'Error send data.'), [
                    'errors' => $order->getErrors()
                ]);
            }

        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Serializes the specified data.
     * The default implementation will create a serializer based on the configuration given by [[serializer]].
     * It then uses the serializer to serialize the given data.
     * @param mixed $data the data to be serialized
     * @return mixed the serialized data.
     */
    private function serializeData($data)
    {
        return Yii::createObject($this->serializer)->serialize($data);
    }
}
