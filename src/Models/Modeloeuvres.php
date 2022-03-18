<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager; 

class Modeloeuvres extends bdmanager
{
    public function readlistoeuvres()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT oeuvre_id, categorie_id, oeuvre_titre, oeuvre_description FROM oeuvres ORDER BY oeuvre_id DESC LIMIT 0, 100');
        return $req;
    }


    public function readoneoeuvre($oeuvreId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT oeuvre_id, categorie_id, oeuvre_titre, oeuvre_description FROM oeuvres WHERE oeuvre_id = ?');
        $req->execute(array($oeuvreId));

        //$datachapter = $req->fetch();

        return $req;
    }
}


