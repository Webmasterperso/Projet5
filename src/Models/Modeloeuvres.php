<?php
require_once("model/Manager.php");

class Modeloeuvres extends Manager
{

    public function readlistoeuvres()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT oeuvre_id, catégorie_id, oeuvre_titre, oeuvre_description FROM oeuvres ORDER BY oeuvre_id DESC LIMIT 0, 100');
        return $req;
    }
}