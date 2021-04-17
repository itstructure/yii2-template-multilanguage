<?php

namespace app\controllers\ajax;

use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\{ContentNegotiator, VerbFilter};
use yii\web\{Controller, Request, Response, BadRequestHttpException};
use ReCaptcha\ReCaptcha;
use app\helpers\BaseHelper;
use app\traits\ResponseTrait;

/**
 * Class RecaptchaAjaxController
 *
 * @package app\controllers
 */
class RecaptchaAjaxController extends Controller
{
    use ResponseTrait;

    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'yii\rest\Serializer';

    /**
     * @var ReCaptcha
     */
    protected $recaptchaDriver;

    /**
     * Initialize.
     */
    public function init()
    {
        parent::init();

        $this->recaptchaDriver = new ReCaptcha(Yii::$app->params['captcha']['secret_key']);
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
            'validate' => ['POST']
        ];
    }

    /**
     * Send new file to upload it.
     *
     * @throws BadRequestHttpException
     *
     * @return array
     */
    public function actionValidate()
    {
        try {
            return $this->checkVerifyCode(Yii::$app->request);

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
    private function checkVerifyCode($request)
    {
        if (!($request instanceof Request)) {
            throw new InvalidArgumentException('Param $request must be instanceof yii\web\Request.');
        }

        $resp = $this->recaptchaDriver->verify($request->post('g_recaptcha_response'), BaseHelper::ip_address());

        if ($resp->isSuccess()) {
            return $this->getSuccessResponse('');
        } else {
            return $this->getFailResponse(Yii::t('feedback', 'Error verify captcha.'), [
                'errors' => $resp->getErrorCodes()
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
