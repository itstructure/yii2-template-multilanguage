<?php

namespace app\controllers\ajax;

use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\{ContentNegotiator, VerbFilter};
use yii\web\{Controller, Request, Response, BadRequestHttpException};
use app\models\Feedback;
use app\traits\ResponseTrait;
use app\helpers\BaseHelper;

/**
 * Class FeedbackAjaxController
 *
 * @package app\controllers
 */
class FeedbackAjaxController extends Controller
{
    use ResponseTrait;

    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'yii\rest\Serializer';

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
            'send' => ['POST']
        ];
    }

    /**
     * Send new file to upload it.
     *
     * @throws BadRequestHttpException
     *
     * @return array
     */
    public function actionSend()
    {
        try {
            return $this->actionSave(Yii::$app->request);

        } catch (InvalidArgumentException|\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Provides upload or update file.
     *
     * @throws InvalidArgumentException
     *
     * @param $request
     *
     * @return array
     */
    private function actionSave($request)
    {
        if (!($request instanceof Request)) {
            throw new InvalidArgumentException('Param $request must be instanceof yii\web\Request.');
        }

        if (!empty($request->post('short_language'))) {
            BaseHelper::setAppLanguage($request->post('short_language'));
        }

        $feedback = new Feedback();
        $feedback->setScenario(Feedback::SCENARIO_FEEDBACK);
        $feedback->setAttributes($request->post(), false);

        if ($feedback->contact(Yii::$app->params['adminEmail'])) {

            return $this->getSuccessResponse(Yii::t('feedback', 'You have successfully sent your message.'));
        } else {

            return $this->getFailResponse(Yii::t('feedback', 'Error send data.'), [
                'errors' => $feedback->getErrors()
            ]);
        }
    }

    /**
     * Serializes the specified data.
     * The default implementation will create a serializer based on the configuration given by [[serializer]].
     * It then uses the serializer to serialize the given data.
     *
     * @param mixed $data the data to be serialized
     *
     * @return mixed the serialized data.
     */
    private function serializeData($data)
    {
        return Yii::createObject($this->serializer)->serialize($data);
    }
}
