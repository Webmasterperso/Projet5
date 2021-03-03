<?php

namespace App\Controllers;

use App\Models\Modeloeuvres as modeloeuvres;
class Control
{
    public function __construct($arg)
    {
        $this->name = $arg;
    }

    public function afficheoeuvres()
    {
        $modeloeuvre = new modeloeuvres(); // Création d'un objet
        $oeuvres = $modeloeuvre->readlistoeuvres(); // Appel d'une fonction de cet objet
        global $twig;
        $dataoeuvres = $oeuvres->fetchAll();
                
        return $twig->render('Viewlistoeuvre.twig', [
            "a_variable" => $this->name,
            "oeuvres" => $dataoeuvres
            
        ]);
    }

    public function afficheuneoeuvres()
    {
        $modeloeuvre = new modeloeuvres(); // Création d'un objet
        $oeuvres = $modeloeuvre->readoneoeuvre($this->name); // Appel d'une fonction de cet objet
        global $twig;
        $dataoeuvres = $oeuvres->fetchAll();

        return $twig->render('Viewlistoeuvre.twig', [
            "a_variable" => $this->name,
            "oeuvres" => $dataoeuvres

        ]);
    }


}
