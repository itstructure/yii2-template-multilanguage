<?php
use yii\helpers\{Html, Url};
use app\helpers\BaseHelper;
use Itstructure\AdminModule\models\Language;
/* @var Language $data */

echo Html::a($data->getName(),
    Url::to(BaseHelper::getSwitchLanguageLink($data->getShortName(), Yii::$app->request)),
    [
        'target' => '_self'
    ]);
?>
