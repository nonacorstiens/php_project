<?php

    abstract class Db
    { //abstracte klasse --> kun je geen instanties van maken
        private static $conn; //static staat voor

        public static function getInstance()
        {

            $config = parse_ini_file('config/config.ini'); //ini file uitlezen en array teruggeven

            //var_dump($config);
            //$this kan hier niet want er zijn geen huidige objecten meer
            if (self::$conn != null) {
                return self::$conn;
            } else {

                self::$conn = new PDO('mysql:host=localhost;dbname='.$config['db_name'].';charset=utf8mb4', $config['db_user'], $config['db_password'], null);

                return self::$conn;
            }
        }
    }
