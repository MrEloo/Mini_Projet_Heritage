<?php


abstract class AbstractManager
{


    protected PDO $db;


    public function __construct()
    {
        $host = "127.0.0.1";
        $port = "3306";
        $dbname = "coindineloan_mini_projet_heritage";
        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = "root";
        $password = "";

        $this->db = new PDO(
            $connexionString,
            $user,
            $password
        );
    }
}
