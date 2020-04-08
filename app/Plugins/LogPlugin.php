<?php

namespace App\Plugins;

class LogPlugin
{

    public static $tableLogs = 'snv_logs_log';
    public static $tableLogsSchema = array(
        array("Id", "STRING", "NOT NULL PRIMARY KEY"),
        array("Category", "STRING"),
        array("Level", "STRING"),
        array("Message", "STRING"),
        array("Context", "STRING"),
        array("Extra", "STRING"),
        array("Time", "DATETIME"),
    );

    /**
     * @return \Sinevia\SqlDb
     */
    public static function getDatabase()
    {
        return db();
    }

    /**
     * @return \Sinevia\SqlDb
     */
    public static function getTableLog()
    {
        return self::getDatabase()->table(self::$tableLogs);
    }

    //public $useUniqueId = true;

    const LEVEL_ALERT = 'ALERT';
    const LEVEL_CRITICAL = 'CRITICAL';
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_EMERGENCY = 'EMERGENCY';
    const LEVEL_ERROR = 'ERROR';
    const LEVEL_INFO = 'INFO';
    const LEVEL_NOTICE = 'NOTICE';
    const LEVEL_WARNING = 'WARNING';

    const CATEGORY_DEFAULT = 'Default';
    const CATEGORY_PAGE_VISIT = 'PageVisit';
    const CATEGORY_PAGE_VISIT_START = 'PageVisitStart';
    const CATEGORY_PAGE_VISIT_END = 'PageVisitEnd';
    const CATEGORY_PAGE_REDIRECT = 'PageRedirect';
    const CATEGORY_STRIPE = 'Stripe';

    public static function alert($category, $message, $context = [])
    {
        return static::log(static::LEVEL_ALERT, $category, $message, $context);
    }

    public static function critical($category, $message, $context = [])
    {
        return static::log(static::LEVEL_CRITICAL, $category, $message, $context);
    }

    public static function debug($category, $message, $context = array())
    {
        return static::log(static::LEVEL_DEBUG, $category, $message, $context);
    }

    public static function emergency($category, $message, $context = [])
    {
        return static::log(static::LEVEL_EMERGENCY, $category, $message, $context);
    }

    public static function error($category, $message, $context = [])
    {
        return static::log(static::LEVEL_ERROR, $category, $message, $context);
    }

    public static function info($category, $message, $context = [])
    {
        return static::log(static::LEVEL_INFO, $category, $message, $context);
    }

    public static function notice($category, $message, $context = [])
    {
        return static::log(static::LEVEL_NOTICE, $category, $message, $context);
    }

    public static function warning($category, $message, $context = [])
    {
        return static::log(static::LEVEL_WARNING, $category, $message, $context);
    }

    public static function getCategoryList()
    {
        $response = static::distinct('Category')
            ->orderBy('Category', 'ASC')
            ->get(['Category'])
            ->toArray();
        return array_column($response, 'Category');
    }

    public static function log($category, $level, $message, $context = array())
    {

        if (is_array($context) == false) {
            $context = ['context' => $context];
        }
        if (isset($context['LoggedUser']) == false) {
            $actorId = \App\Helpers\App::userId();
            $context['LoggedUser'] = $actorId;
            $context['Ip'] = \Sinevia\Utils::ip();
        }

        $log = new static;
        $log->Id = \Sinevia\UidUtils::microUid();
        $log->Category = $category;
        $log->Level = $level;
        $log->Message = $message;
        $log->Context = json_encode($context);
        $log->Time = date('Y-m-d H:i:s');
        if ($log->save()) {
            return $log->Id;
        }
        return null;
    }

    public static function createTables()
    {
        if (self::getTableLog()->exists() == false) {
            self::getTableLog()->create(self::$tableLogsSchema);
        }
    }
}