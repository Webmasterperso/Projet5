<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager;

class Modelusers extends bdmanager
{
    public function readlistusers()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT user_id, user_pseudo, user_nom, user_prenom, user_mail, user_mdp, user_role, user_adresse, user_cp, user_ville, user_telephone FROM users');
        $datausers = $req->fetchAll();
        return $datausers;
    }

    public function readoneuser($userpseudo)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT user_id, user_pseudo, user_nom, user_prenom, user_mail, user_mdp, user_role, user_adresse, user_cp, user_ville, user_telephone FROM users WHERE user_pseudo = ?');
        $req->execute(array($userpseudo));
        $datauser = $req->fetchAll();
        return $datauser;

        //$datachapter = $req->fetch();

        //return $req;
    }

    public function createuser($userpseudo, $usernom, $userprenom, $usermail, $usermdp, $userrole,$useradresse, $usercp, $userville, $usertelephone)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(user_pseudo, user_nom, user_prenom, user_mail, user_mdp, user_role, user_adresse, user_cp, user_ville, user_telephone)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        
        $datauser = $req->execute(array($userpseudo, $usernom, $userprenom, $usermail, $usermdp, $userrole, $useradresse, $usercp, $userville, $usertelephone));
        return $datauser;
    }

    public function modifuser($pseudo, $nom, $prenom, $mail, $mdp, $role, $adresse, $cp, $ville, $telephone, $id)
    {
        $db = $this->dbConnect();
        
        $req = $db->prepare('UPDATE users SET user_pseudo=?, user_nom=?, user_prenom=?, user_mail=?, user_mdp=?, user_role=?, user_adresse=?, user_cp=?, user_ville=?, user_telephone=? WHERE user_id=?');
        $datachangeuser = $req->execute(array($pseudo, $nom, $prenom, $mail, $mdp, $role, $adresse, $cp, $ville, $telephone, $id));

        return $datachangeuser;
    }

    



}
