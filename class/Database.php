<?php
class Database
{
    public static function getConnect()
    {
        $host = "localhost";
        $db = "db_bakery";
        $username = "ad_dbBakery1";
        $password = "tE]MN0@no1Y0!DUc";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $username, $password);
        
            if ($pdo) {
                return $pdo;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }
    }


}