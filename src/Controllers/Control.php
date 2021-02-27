<?php

namespace App\Controllers;

use App\Models\Modeloeuvres as ModelOeuvres;

class Control
{
    public function __construct($arg)
    {
        $this->name = $arg;
    }

    function listoeuvre()
    {
        $modeloeuvre = new Modeloeuvres(); // Création d'un objet
        $oeuvres = $modeloeuvre->readlistoeuvres(); // Appel d'une fonction de cet objet

        require('view/Viewlistchapter.php');
    }

    public function affiche()
    {
        global $twig;
        return $twig->render('templateinit.twig', [
            "a_variable" => $this->name,
            "users" => [
                [
                    "username" => "lien1.html",
                    "caption" => "premier lien"
                ],
                [
                    "username" => "lien2.html",
                    "caption" => "second lien"
                ]
            ]
        ]);
    }
}
