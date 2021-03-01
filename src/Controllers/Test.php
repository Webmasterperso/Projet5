<?php

namespace App\Controllers;

use APP\Models\Modeloeuvres as ModelOeuvres;

class Test  
{
    public function __construct($arg)
    {
        $this->name = $arg;
    }

    public function affiche()
    {
        global $twig;
        return $twig->render('demo.twig', [
            "a_variable" => $this->name,
            "users" =>[
                [
                    "username"=>"lien1.html",
                    "caption"=>"premier lien"
                ],
                [
                    "username" => "lien2.html",
                    "caption" => "second lien"
                ]
            ]
        ]);
    }
}
