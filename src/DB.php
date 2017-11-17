<?php

class DB
{
    static $conn;

    private static function getDsnFromConfig($config) {
        return "mysql:host=".$config["host"].";dbname=".$config["base"];
    }

    private static function readConfig() {
        $array = file(__DIR__."/../.config",FILE_IGNORE_NEW_LINES);
        $res = [];
        foreach ($array as $line) {
            $data = explode("=",$line);
            $res[$data[0]] = $data[1]==="null" ? null : $data[1];
        }
        return $res;
    }

    public static function init(){
        if(!self::$conn) {
            $config = self::readConfig();
            $dsn = self::getDsnFromConfig($config);
            self::$conn = new \PDO($dsn,$config['user'],$config['pass']);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
    }
}