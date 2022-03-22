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
        $req = $db->query('SELECT user_id, user_pseudo, user_mail, user_mdp FROM users');
        $datausers = $req->fetchAll();
        return $datausers;
    }

    public function readoneuser($userpseudo, $usermdp)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT user_id, user_pseudo, user_mail, user_mdp, user_role FROM users WHERE user_pseudo = ? AND user_mdp = ?');
        $req->execute(array($userpseudo, $usermdp));
        $datauser = $req->fetchAll();
        return $datauser;

        //$datachapter = $req->fetch();

        //return $req;
    }

    public function createuser($userpseudo, $usermail, $usermdp, $userrole)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(user_pseudo, user_mail, user_mdp, user_role)VALUES(?, ?, ?, ?)');
        //$req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        $datauser = $req->execute(array($userpseudo, $usermail, $usermdp, $userrole));
        return $datauser;
    }



}
