<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager;

class Modelcaddie extends bdmanager
{
    public function readlistcommand()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT caddie_id, caddie_date, caddie_user, caddie_prix FROM caddie ORDER BY caddie_id DESC LIMIT 0, 100');
        $datacaddies = $req->fetchAll();
        return $datacaddies;
    }

    public function readcommandbyuser($usercaddie)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT caddie_id, caddie_date, caddie_user, caddie_prix FROM caddie WHERE caddie_user = ?');
        $req->execute(array($usercaddie));
        $datacaddiebyuser = $req->fetchAll();
        return $datacaddiebyuser;
        return $req;
    }

    public function createcommand($caddiedate, $caddieuser, $caddieprix)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO caddie(caddie_date, caddie_user, caddie_prix)VALUES(?, ?, ?)');
        //$req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        $datanewcaddie = $req->execute(array($caddiedate, $caddieuser, $caddieprix));
        return $datanewcaddie;
    }

    public function readoeuvresbycommand($idcommand)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT caddie_oeuvre_id, caddie_oeuvre_id_oeuvre, caddie_oeuvre_id_caddie, caddie_oeuvre_titre, caddie_oeuvre_description, caddie_oeuvre_lien, caddie_oeuvre_prix FROM caddie_oeuvre WHERE caddie_oeuvre_id_caddie = ?');
        $req->execute(array($idcommand));
        $datacaddiebycommand = $req->fetchAll();
        return $datacaddiebycommand;
        return $req;
        
    }

    public function createoeuvrecommand($idoeuvre, $idcaddie, $oeuvretitre, $oeuvredescription, $oeuvrelien, $oeuvreprix)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO caddie_oeuvre(caddie_oeuvre_id_oeuvre, caddie_oeuvre_id_caddie, caddie_oeuvre_titre, caddie_oeuvre_description, caddie_oeuvre_lien, caddie_oeuvre_prix)VALUES(?, ?, ?, ?, ?, ?)');
        //$req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        $datanewcaddieoeuvre = $req->execute(array($idoeuvre, $idcaddie, $oeuvretitre, $oeuvredescription, $oeuvrelien, $oeuvreprix));
        return $datanewcaddieoeuvre;
    }
}
