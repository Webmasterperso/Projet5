<?php

namespace App\Controllers;



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
                    "username"=>"lien1",  
                    "username" => "lien2"
            ]
        ]);
    }
}
