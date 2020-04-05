<?php

namespace App\Helpers;

class Links extends \Sinevia\LinkUtils
{

    public static function authPasswordlessUrl($queryData = array())
    {
        $backUrl = self::guestHome();
        $nextUrl = self::authPasswordless();
        $passwordlessUrl = 'https://authknight.com/login?back_url=' . \urlencode($backUrl) . '&next_url=' . \urlencode($nextUrl);
        return $passwordlessUrl;
    }

    public static function authPasswordless($queryData = array())
    {
        return self::buildUrl('/auth/passwordless', $queryData);
    }

    public static function authLogin($queryData = array())
    {
        return self::buildUrl('/auth/login', $queryData);
    }

    public static function authLogout($queryData = array())
    {
        return self::buildUrl('/auth/logout', $queryData);
    }

    public static function guestHome($queryData = array())
    {
        return self::buildUrl('/', $queryData);
    }

    public static function userHome($queryData = array())
    {
        return self::buildUrl('/user', $queryData);
    }

    public static function buildUrl($path, $queryData = array())
    {
        return parent::buildUrl($path, $queryData);
    }
}