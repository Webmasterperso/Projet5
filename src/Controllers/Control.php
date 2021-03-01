<?php

namespace App\Controllers;

use App\Models\Modeloeuvres as modeloeuvres;




class Control
{
    public function __construct($arg)
    {
        $this->name = $arg;
        //$this->oeuvres = $dataoeuvre;
       
    }

   
    public function affiche()
    {
        $modeloeuvre = new modeloeuvres(); // Création d'un objet
        $oeuvres = $modeloeuvre->readlistoeuvres(); // Appel d'une fonction de cet objet
        global $twig;
        return $twig->render('Viewlist.twig', [
            "moteur_name" => 'Twig',
            "a_variable" => $this->name,
            "oeuvres" => "liste oeuvre"
        ]);
    }
}
