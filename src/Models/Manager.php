<?php

namespace App\Models;
use PDO;
use PDOException;
class Manager
{

    protected function dbConnect()
    {
        try {
            //$db = new PDO('mysql:host=webmasterperso.fr.mysql;dbname=webmasterperso_;charset=utf8', 'webmasterperso_', 'webmaster2579');
            $db = new PDO('mysql:host=localhost:8887.mysql;dbname=madamet;charset=utf8', 'massond', 'adminprojet5');
            return $db;
        } catch (PDOException $e) {
            die('Echec connection Base de données : ' . $e->getMessage());
        }
    }
}