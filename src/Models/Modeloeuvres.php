<?php

namespace App\Models;

//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");

use App\Models\Manager as bdmanager; 

class Modeloeuvres extends bdmanager
{
    

    public function readlistoeuvres()
    {
        //$db = $this->dbConnect();
        $req = $db->query('SELECT oeuvre_id, catégorie_id, oeuvre_titre, oeuvre_description FROM oeuvres ORDER BY oeuvre_id DESC LIMIT 0, 100');
        
        $dataoeuvre = $req->fetch();
        return $dataoeuvre;
    }
}


