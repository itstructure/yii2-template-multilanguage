<?php

namespace app\helpers;

use Yii;
use yii\web\Request;
use yii\web\BadRequestHttpException;
use Itstructure\AdminModule\models\Language;

/**
 * Class BaseHelper
 *
 * @package app\helpers
 */
class BaseHelper
{
    /**
     * @param string $date
     * @param string $format
     *
     * @return string
     */
    public static function getDateAt(string $date, string $format = 'd.m.Y H:i:s'): string
    {
        $inDateTime = new \DateTime($date);

        return date($format, $inDateTime->getTimestamp());
    }

    /**
     * @param string $newShortLanguage
     * @param Request $request
     *
     * @return string
     */
    public static function getSwitchLanguageLink(string $newShortLanguage, Request $request): string
    {
        $url = trim($request->url, '/');

        $urlArray = explode('/', $url);

        $urlArray[0] = $newShortLanguage;

        return '/' . implode('/', $urlArray);
    }

    /**
     * @param string|null $shortLanguage
     *
     * @throws BadRequestHttpException
     */
    public static function setAppLanguage(string $shortLanguage = null)
    {
        if (empty($shortLanguage)) {
            throw new BadRequestHttpException('Parameter "shortLanguage" is not defined.');
        }

        $langModel = Language::find()->where([
            'shortName' => $shortLanguage
        ])->one();

        if (null === $langModel) {
            throw new BadRequestHttpException('There are not any data for language: '.$shortLanguage);
        }

        Yii::$app->language = $langModel->locale;
    }

    /**
     * Detect client (browser) short language.
     *
     * @return mixed
     */
    public static function detectClientShortLanguage()
    {
        if (!isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) || empty($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
            return null;
        }

        preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/',
            strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]),
            $matches
        );

        $langs = array_combine($matches[1], $matches[2]);

        foreach ($langs as $n => $v) {
            $langs[$n] = $v ? $v : 1; // If no q, then set q = 1
        }

        arsort($langs); // Sort descending q

        $language = key($langs);

        return strlen($language) > 2 ? substr($language, 0, 2) : $language;
    }

    /**
     * @return string
     */
    public static function ip_address()
    {
        $fields = array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');

        $ip = "0.0.0.0";
        foreach($fields as $k)
        {
            if(!empty($_SERVER[$k]) && ip2long($_SERVER[$k]) != false)
            {
                $ip = $_SERVER[$k];
            }
        }

        return $ip;
    }
}
