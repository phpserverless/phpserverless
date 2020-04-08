<?php

namespace App\Plugins;

class BasePlugin
{

    /**
     * Enables or disables the debug
     * @var bool
     */
    public static $debug = false;

    /**
     * Logs the debug messages
     * @param string $message
     */
    public static function log($message)
    {
        if (isset($_COOKIE['debug']) && $_COOKIE['debug'] == 'file') {
            // Debug to debug.txt
            $msg = "[" . date('Y-m-d H:i:s') . "] http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\r\n";
            $msg .= "" . $message . "\r\n";
            $file = ROOT_DIR . '/debug.txt';
            file_put_contents($file, $msg, FILE_APPEND);
        }
    }
}