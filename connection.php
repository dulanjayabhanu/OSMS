<?php

    class Database{
        public static $connection;
        
        public static function setUpConnection(){
            if(!isset(Database::$connection)){
                Database::$connection = new mysqli("localhost","root","459@SofT#374","osms","3306");
            }
        }

        public static function insertUpdateDelete($q){
            Database::setUpConnection();
            Database::$connection->query($q);
        }

        public static function search($q){
            Database::setUpConnection();
            $resultset = Database::$connection->query($q);
            return $resultset;
        }
    }

?>