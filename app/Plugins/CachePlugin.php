<?php

namespace App\Plugins;

class CachePlugin
{

    public static $settings = [];
    public static $tableCache = 'snv_cache';
    public static $tableCacheSchema = array(
        array("Id", "STRING", "NOT NULL PRIMARY KEY"),
        //array("Namespace", "STRING"),
        array("CacheKey", "STRING"),
        array("CacheValue", "TEXT"),
        array("ExpiresAt", "DATETIME"),
        array("CreatedAt", "DATETIME"),
        array("UpdatedAt", "DATETIME"),
        array("DeletedAt", "DATETIME"),
    );

    public static function createTables()
    {
        //self::getDatabase()->debug = true;
        if (self::getTableCache()->exists() == false) {
            self::getTableCache()->create(self::$tableCacheSchema);
        }
    }

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
    public static function getTableCache()
    {
        return self::getDatabase()->table(self::$tableCache);
    }

    /**
     * Checks if a key exists
     * @param string $key
     * @return bool
     */
    public static function exists($key)
    {
        $cache = self::getTableCache()
            ->where('CacheKey', '=', $key)
            ->selectOne();

        if ($cache != null) {
            return true;
        }

        return false;
    }

    /**
     * Deletes all expired keys
     */
    public static function purge()
    {
        return self::getTableCache()
            ->where('ExpiresAt', '<', date('Y-m-d H:i:s'))
            ->delete();
    }

    /**
     * Deletes a key
     */
    public static function delete(string $key)
    {
        /* 1. Delete expired cache */
        self::purge();

        /* 2. Get the cache from the database */
        $result = self::getTableCache()
            ->where('CacheKey', '=', $key)
            ->delete();

        return $result;
    }

    /**
     * Gets the value of a setting
     * @param string $namespace
     * @param string $key
     * @param string $default
     * @return string|array
     */
    public static function get($key, $default = null)
    {
        $cache = self::getTableCache()
            ->where('CacheKey', '=', $key)
            ->selectOne();

        if ($cache == null) {
            return $default;
        }

        return json_decode($cache['CacheValue'], true);
    }

    /**
     * Sets a new setting
     * @param string $namespace
     * @param string $key
     * @param string $value
     * @return boolean
     */
    public static function set(string $key, $value,  string $expires = "1 hour")
    {
        $cache = self::getTableCache()
            ->where('CacheKey', '=', $key)
            ->selectOne();

        if ($cache != null) {
            $isUpserted = self::getTableCache()
                ->where('CacheKey', '=', $key)
                ->update([
                    'CacheValue' => json_encode($value),
                    'ExpiresAt' => date('Y-m-d H:i:s', strtotime('+' . $expires)),
                ]);
        } else {
            $isUpserted = self::getTableCache()->insert([
                'Id' => \Sinevia\UidUtils::humanUuid(),
                'CacheKey' => $key,
                'CacheValue' => json_encode($value),
                'ExpiresAt' => date('Y-m-d H:i:s', strtotime('+' . $expires)),
            ]);
        }

        return $isUpserted === false ? false : true;
    }
}