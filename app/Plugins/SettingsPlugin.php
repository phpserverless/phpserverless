<?php

namespace App\Plugins;

class SettingsPlugin
{

    public static $settings = [];
    public static $tableSetting = 'snv_settings_setting';
    public static $tableSettingSchema = array(
        array("Id", "STRING", "NOT NULL PRIMARY KEY"),
        array("Namespace", "STRING"),
        array("Key", "STRING"),
        array("Value", "TEXT"),
        array("CreatedAt", "DATETIME"),
        array("UpdatedAt", "DATETIME"),
        array("DeletedAt", "DATETIME"),
    );

    public static function createTables()
    {
        //self::getDatabase()->debug = true;
        if (self::getTableSetting()->exists() == false) {
            self::getTableSetting()->create(self::$tableSettingSchema);
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
    public static function getTableSetting()
    {
        return self::getDatabase()->table(self::$tableSetting);
    }

    /**
     * Gets the value of a setting
     * @param string $namespace
     * @param string $key
     * @param string $default
     * @return string|array
     */
    public static function get($namespace, $key, $default = null)
    {
        //        if (isset(self::$settings[$namespace . $key])) {
        //            return self::$settings[$namespace . $key];
        //        }

        $setting = self::getTableSetting()->where('Namespace', '=', $namespace)
            ->where('Key', '=', $key)
            ->selectOne();

        if ($setting == null) {
            return $default;
        }

        return json_decode($setting['Value'], true);
    }

    /**
     * Sets a new setting
     * @param string $namespace
     * @param string $key
     * @param string $value
     * @return boolean
     */
    public static function set($namespace, $key, $value)
    {
        $setting = self::getTableSetting()->where('Namespace', '=', $namespace)
            ->where('Key', '=', $key)
            ->selectOne();

        if ($setting == null) {
            $isUpserted = self::getTableSetting()->where('Namespace', '=', $namespace)
                ->where('Key', '=', $key)
                ->update([
                    'Value' => json_encode($value)
                ]);
        } else {
            $isUpserted = self::getTableSetting()->insert([
                'Namespace' => $namespace,
                'Key' => $key,
                'Value' => json_encode($value)
            ]);
        }

        self::$settings[$namespace . $key] = $value;

        return $isUpserted === false ? false : true;
    }
}