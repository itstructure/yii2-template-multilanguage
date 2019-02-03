<?php

namespace app\components;

use Yii;
use yii\base\{Model, Component};
use app\models\Setting;

/**
 * Class SettingsComponent
 * Component class for settings tuning.
 *
 * @package app\components
 */
class SettingsComponent extends Component
{
    /**
     * Sets Settings model.
     *
     * @return Model
     */
    public function setModel(): Model
    {
        /** @var Model $object */
        $object = Yii::createObject([
            'class' => Setting::class,
            'tableName' => 'settings',
            'db' => Yii::$app->db
        ]);

        return $object;
    }
}
