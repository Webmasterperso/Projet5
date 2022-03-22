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
        $req = $db->query('SELECT oeuvre_id, categorie_id, oeuvre_titre, oeuvre_description, oeuvre_lien, oeuvre_prix, oeuvre_statut FROM oeuvres ORDER BY oeuvre_id DESC LIMIT 0, 100');
        $dataoeuvres = $req->fetchAll();
        return $dataoeuvres;
    }


    public function readoneoeuvre($oeuvreId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT oeuvre_id, categorie_id, oeuvre_titre, oeuvre_description, oeuvre_lien, oeuvre_prix, oeuvre_statut FROM oeuvres WHERE oeuvre_id = ?');
        $req->execute(array($oeuvreId));
        $dataoeuvre = $req->fetchAll();
        return $dataoeuvre;

        //$datachapter = $req->fetch();

        return $req;
    }

    public function readoeuvrebycat($categorieid)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT oeuvre_id, categorie_id, oeuvre_titre, oeuvre_description, oeuvre_lien , oeuvre_prix, oeuvre_statut FROM oeuvres WHERE categorie_id = ?');
        $req->execute(array($categorieid));
        $dataoeuvre = $req->fetchAll();
        return $dataoeuvre;

        //$datachapter = $req->fetch();

        return $req;
    }

    public function readlistcat()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT categorie_id, categorie_nom FROM categories ORDER BY categorie_nom');
        $datacategories = $req->fetchAll();
        return $datacategories;
    }

    public function createoeuvre($catid, $oeuvretitre, $oeuvredescription, $oeuvrelien, $prix, $statut)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO oeuvres(categorie_id, oeuvre_titre, oeuvre_description, oeuvre_lien, oeuvre_prix, oeuvre_statut)VALUES(?, ?, ?, ?, ?, ?)');
        //$req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        $dataoeuvre = $req->execute(array($catid, $oeuvretitre, $oeuvredescription, $oeuvrelien, $prix, $statut));
        return $dataoeuvre;
    }


    public function modifoeuvre($catid, $oeuvretitre, $oeuvredescription, $oeuvrelien, $prix, $statut, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE oeuvres SET categorie_id=?, oeuvre_titre=?, oeuvre_description=?, oeuvre_lien=?, oeuvre_prix=?, oeuvre_statut=? WHERE oeuvre_id=?');
        $dataoeuvre = $req->execute(array($catid, $oeuvretitre, $oeuvredescription, $oeuvrelien, $prix, $statut, $id));

        return $dataoeuvre;
    }

    public function deleteoeuvre($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM oeuvres WHERE oeuvre_id=?');
        $deleteoeuvre = $req->execute(array($id));

        return $deleteoeuvre;
    }

}


