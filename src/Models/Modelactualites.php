<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager;

class Modelactualites extends bdmanager
{
    public function readlistactualite()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT actualite_id, actualite_titre, DATE_FORMAT(actualite_date, \'%m %Y\') AS date_actualite_fr, actualite_text, actualite_lien FROM actualites ORDER BY actualite_date DESC LIMIT 0, 5');
        $dataactualite = $req->fetchAll();
        //die(var_dump($dataactualite));
        return $dataactualite;
        
    }

    public function modifactualite($actutitre, $actudescription, $actulien, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE actualites SET actualite_titre=?, actualite_text=?, actualite_lien=? WHERE actualite_id=?');
        $dataactualite = $req->execute(array($actutitre, $actudescription, $actulien, $id));

        return $dataactualite;
    }

    public function createactualite($actutitre, $actudescription, $actulien)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO actualites(actualite_titre, actualite_date, actualite_text, actualite_lien)VALUES(?, now(),?, ?)');
        //$req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        $dataactualite = $req->execute(array($actutitre, $actudescription, $actulien));
        return $dataactualite;
    }

    public function deleteactualite($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM actualites WHERE actualite_id=?');
        $deleteoeuvre = $req->execute(array($id));

        return $deleteoeuvre;
    }


   
}


