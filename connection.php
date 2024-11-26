<?php

class Database{

    public static $connection;

    public static function setUpConnection(){
        if(!isset(Database::$connection)){
            Database::$connection = new mysqli("localhost","root","Password","phoneshop2","3306");
        }
    }

    public static function iud($q){
        database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q){
        database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }

}

?>
