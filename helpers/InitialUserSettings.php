<?php

namespace app\helpers;

use Yii;
use yii\rbac\DbManager;
use yii\db\TableSchema;
use yii\web\IdentityInterface;

/**
 * Class InitialUserSettings
 *
 * This class for setting initial user settings, such as status and role after registration.
 */
class InitialUserSettings
{
    /**
     * Initial constants.
     */
    const INIT_USER_STATUS = 1;
    const INIT_USER_ROLE = 'admin';

    const AUTH_MANAGER_CLASS = DbManager::class;

    /**
     * Set initial user settings.
     *
     * @param IdentityInterface $user
     *
     * @return bool
     */
    public static function run(IdentityInterface $user): bool
    {
        $db = Yii::$app->db;

        /* @var $settingsTableSchema TableSchema */
        $settingsTableSchema = $db->getTableSchema('settings');

        if (null === $settingsTableSchema) {
            Yii::error('Table "settings" does not exists for initial user properties.');
            return false;
        }

        $settings = $db->createCommand('SELECT * FROM settings')
            ->queryOne();

        self::setUserStatus($settingsTableSchema, $settings, $user);

        self::setUserRole($settingsTableSchema, $settings, $user);

        return true;
    }

    /**
     * Set initial user status.
     *
     * @param TableSchema $settingsTableSchema
     * @param array|bool $settings
     * @param IdentityInterface $user
     *
     * @return void
     */
    private static function setUserStatus(TableSchema $settingsTableSchema, $settings, IdentityInterface $user): void
    {
        if (in_array('initUserStatus', $settingsTableSchema->columnNames)) {
            $user->status = is_array($settings) && null !== $settings['initUserStatus'] ?
                $settings['initUserStatus'] : self::INIT_USER_STATUS;
            $user->save();
        } else {
            Yii::error('Field "initUserStatus" does not exists in "settings" table to set initial user status.');
        }
    }

    /**
     * Set initial user role.
     *
     * @param TableSchema $settingsTableSchema
     * @param array|bool $settings
     * @param IdentityInterface $user
     *
     * @return void
     */
    private static function setUserRole(TableSchema $settingsTableSchema, $settings, IdentityInterface $user): void
    {
        if (in_array('initUserRole', $settingsTableSchema->columnNames)) {

            /* @var $authManager \yii\rbac\BaseManager */
            $authManager = Yii::$app->get('authManager');

            if (null === $authManager) {
                $authManager = Yii::createObject([
                    'class' => self::AUTH_MANAGER_CLASS,
                ]);
            }

            if (!is_array($settings) || null === $settings['initUserRole']) {
                $initUserRole = self::INIT_USER_ROLE;
                Yii::error('Can not get field value of "initUserRole" from "settings" table to set initial user role.');
            } else {
                $initUserRole = $settings['initUserRole'];
            }

            $authManager->assign(
                $authManager->getRole($initUserRole),
                $user->getId()
            );

        } else {
            Yii::error('Field "initUserRole" does not exists in "settings" table to set initial user role.');
        }
    }
}
