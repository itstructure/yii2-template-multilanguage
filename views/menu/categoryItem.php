<?php
use yii\helpers\{Html, Url, ArrayHelper};
/* @var app\models\Category $data */
/* @var string $shortLanguage */
/* @var array $linkOptions */

if (!isset($linkOptions)) {
    $linkOptions = [];
}

echo Html::a($data->{'title_'.$shortLanguage},
    Url::to('/'.$shortLanguage.'/category/'.$data->alias),
    ArrayHelper::merge([
        'target' => '_self'
    ], $linkOptions)
);
?>
