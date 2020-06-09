<?php
use yii\helpers\{Html, Url, ArrayHelper};
/* @var app\models\Page $data */
/* @var string $shortLanguage */
/* @var array $linkOptions */

if (!isset($linkOptions)) {
    $linkOptions = [];
}

echo Html::a($data->{'title_'.$shortLanguage},
    Url::to('/'.$shortLanguage.'/page/'.$data->alias),
    ArrayHelper::merge([
        'target' => '_self'
    ], $linkOptions)
);
?>
