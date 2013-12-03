<?php

/**
 * Allows the db connection to be passed directly. 
 * Helpful when the connection component is nexted within another one 
 */
class DbCacheDependency extends CDbCacheDependency {

    /**
     * @var string the ID of a {@link CDbConnection} application component. Defaults to 'db'.
     */
    private static $connection;
    public static $value;

    public function setDbConnection($connection) {
        self::$connection = $connection;
    }

    public function __construct($value) {
        self::$value = $value;
    }

    /**
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     */
    protected function getDbConnection() {
        return self::$connection;
    }

    protected function generateDependentData() {
        return self::$value;
    }
}
