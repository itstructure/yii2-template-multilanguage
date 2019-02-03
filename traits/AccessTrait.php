<?php

namespace app\traits;

use Yii;

/**
 * Class AccessTrait
 *
 * @package app\traits
 */
trait AccessTrait
{
    /**
     * @var bool
     */
    protected $check_access = true;

    /**
     * @return bool
     */
    protected function checkAccessToAdministrate()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('VIEW_BACKSIDE')
            && Yii::$app->user->can('CREATE')
            && Yii::$app->user->can('UPDATE')
            && Yii::$app->user->can('DELETE')
            && Yii::$app->user->can('SET_ROLES')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToIndex()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('VIEW_BACKSIDE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToView()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('VIEW_BACKSIDE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToCreate()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('CREATE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToUpdate()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('UPDATE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToDelete()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('DELETE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkAccessToSetRoles()
    {
        if (!$this->check_access) {
            return true;
        }

        if (Yii::$app->user->can('SET_ROLES')) {
            return true;
        }

        return false;
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    protected function accessError(string $message = '')
    {
        return $this->render('@app/views/admin/errors/access_error', [
            'message' => !empty($message) ? $message : Yii::t('app', 'You do not have any permissions to perform this action.')
        ]);
    }
}
