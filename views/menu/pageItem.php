<?php
use yii\helpers\{Html, Url};
/* @var app\models\Page $data */
/* @var string $shortLanguage */
?>
<?php echo Html::a($data->{'title_'.$shortLanguage},
    Url::to('/'.$shortLanguage.'/page/'.$data->id),
    [
        'target' => '_self'
    ]);
?>
