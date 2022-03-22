<?php

namespace App\Models;
//require_once __DIR__ . '/../Models/Manager.php';
//require_once("Models/Manager.php");
use App\Models\Manager as bdmanager; 

class Modelupload extends bdmanager
{
    public function uploadfiles($extensionsAutorisees)
    {
        $nomOrigine = $_FILES['monfichier']['name'];
        $elementsChemin = pathinfo($nomOrigine);
        $extensionFichier = $elementsChemin['extension'];
        //$extensionsAutorisees = array("jpeg", "jpg", "gif");
        if (!(in_array($extensionFichier, $extensionsAutorisees))) {
            echo "Le fichier n'a pas l'extension attendue";
        } else {    
        // Copie dans le repertoire du script avec un nom
        // incluant l'heure a la seconde pres 
            $repertoireDestination = dirname(__FILE__)."/";
            $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

            if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                $repertoireDestination.$nomDestination)) {
                echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                    " a été déplacé vers ".$repertoireDestination.$nomDestination;
            } else {
                echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                    "Le déplacement du fichier temporaire a échoué".
                    " vérifiez l'existence du répertoire ".$repertoireDestination;
            }
        }
    }
}