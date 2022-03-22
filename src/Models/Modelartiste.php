<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager;

class Modelartiste extends bdmanager
{
    public function readoneartiste()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT artiste_id, artiste_title, artiste_text, artiste_photo FROM artiste WHERE artiste_id = 1');
        $dataartiste = $req->fetchAll();
        //die(var_dump($dataactualite));
        return $dataartiste;
    }

    public function saveartiste($artistetitle, $artistetext, $artistephoto)
    {
        $db = $this->dbConnect();
        $artiste = $db->prepare('UPDATE artiste SET artiste_title=?, artiste_text=?, artiste_photo=? WHERE artiste_id = 1');
        $affectedLines = $artiste->execute(array($artistetitle, $artistetext, $artistephoto));

        return $affectedLines;
    }

    
}

