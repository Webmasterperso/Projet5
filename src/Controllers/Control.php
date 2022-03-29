<?php

namespace App\Controllers;

use App\Models\Modeloeuvres as modeloeuvres;
use App\Models\Modelactualites as modelactualites;
use App\Models\Modelusers as modelusers;
use App\Models\Modelartiste as modelartiste;
use DateTime;

//use phpmailer\phpmailer\PHPMailer as phpmailer;
//use PHPMailer\PHPMailer\SMTP;

//require __DIR__ . '../vendor/autoload.php';
//require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';
//require 'vendor\phpmailer\phpmailer\src\SMTP.php';

class Control
{

    public $template = null;
    public $titre = null;
    public $alerte = null;
    public $data = null;
    public $modeloeuvre = null;
    public $status = 200;
    public $data1 = null;
    public $rang = null;
    public $curseur = 0;
    public $rangcourant;
    public $datacat = null;
    public $datauser = null;
    public $dataartiste = null;
    public $dataactualite = null;
    public $nom = null;
    public $prenom = null;
    public $mailvisitor = null;
    public $message = null;
    public $session = null;
    public $nomOrigine = null;
    public $elementsChemin = null;
    public $extensionFichier = null;
    public $extensionsAutorisees = null;
   


    


    public function __construct($args)
    {
        $this->modeloeuvre = new modeloeuvres(); // Création d'un objet
        $this->modelactualite = new modelactualites();
        $this->modeluser = new modelusers();
        $this->modelartiste = new modelartiste();

        if (isset($_SESSION)) {
            $this->session = $_SESSION;
            //die(var_dump($_SESSION['user']));

            //die(var_dump($this->session));
        }

        
       if (count($args) === 0) {
            return $this->accueil();
            //die(var_dump($dataform));
        }

       if(count($args) === 1) {
            
           if(method_exists($this, $args["nomPage"])) {
               //die(var_dump($args));
                $nomfoncion = $args["nomPage"];
                //die(var_dump($nomfoncion));
                //return $this->session();
                return $this->$nomfoncion();
                //return $this->oeuvres();
            }
/*
            if (method_exists($this, $args["action"])) {
                //die(var_dump($args));
                //die(var_dump($args["nomPage"]));
                $nomfoncion = $args["action"];
                //die(var_dump($nomfoncion));
                return $this->$nomfoncion($args);
                //return $this->oeuvres();
            }
*/
        }

        if(count($args) === 2) {
            //die(var_dump($args));
           if(method_exists($this, $args["nomPage"])) {
               //die(var_dump($args["nomPage"]));
                $nomfoncion = $args["nomPage"];
                //die(var_dump($nomfoncion));
                return $this->$nomfoncion($args);
                //return $this->oeuvres();
            }
            
        }

        if (count($args) === 3) {
            //die(var_dump($args["nomPage"]));
            if (method_exists($this, $args["nomPage"])) {
                //die(var_dump($args["nomPage"]));
                $nomfoncion = $args["nomPage"];
                //die(var_dump($nomfoncion));

                return $this->$nomfoncion($args);
                //return $this->oeuvres();
            }
        }

        //die(var_dump(count($args)));
        $this->status = 404;
        $this->template =  "page404.twig";

    }

    public function session()
    {
        //die(var_dump($_SESSION['user']));
        if (isset($_SESSION)) {
            $this->session = $_SESSION;
            //die(var_dump($_SESSION['user']));

            //die(var_dump($this->session));
        }
    }

    

    public function accueil()
    {
        $this->titre = "Une feuille de papier, un crayon, et tout devient  source d’inspiration!​";
        $this->data = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //die(var_dump($this->data));
        $this->template = 'Viewaccueil.twig';
    }

    public function oeuvres()
    {
        $this->titre = "Les oeuvres";
        $this->data = $this->modeloeuvre->readlistoeuvres(); // Appel d'une fonction de cet objet
        $this->datacat = $this->modeloeuvre->readlistcat();
        //die(var_dump($this->data));
        $this->template = 'Viewlistoeuvre.twig';
    }

    public function oeuvrescat($args)
    {
        $this->titre = "Les oeuvres";
        $this->rang = $args["categorieid"];
        if ($args["categorieid"] == 0) {
            $this->data = $this->modeloeuvre->readlistoeuvres();
        } else {
            $this->data = $this->modeloeuvre->readoeuvrebycat($args["categorieid"]);
        }

        $this->datacat = $this->modeloeuvre->readlistcat();
        //die(var_dump($this->data));
        if(isset($_SESSION["role"]) AND $_SESSION["role"]=="admin") {
            $this->template = 'Viewlistoeuvreedit.twig';
        }
        else {
            $this->template = 'Viewlistoeuvre.twig';
        }
        
    }

    public function oeuvre($args)
    {
        $this->titre = "Details des oeuvres";
        if ($args["categorieid"] != 0)
        {
            //die(var_dump($this->data));
            $this->data = $this->modeloeuvre->readoeuvrebycat($args["categorieid"]);
        }
        else
        {
            //die(var_dump($this->data));
            $this->data = $this->modeloeuvre->readlistoeuvres($args["categorieid"]);
        }
        $this->data1 = $this->modeloeuvre->readoneoeuvre($args["idOeuvre"]);
        
        //$this->rang = array_search($this->data1[0], $this->data );
        $this->template = 'Viewoneoeuvre.twig';
    }

    public function oeuvreedit()
    {
        $this->titre = "Oeuvres - Admin";
        //die(var_dump(count($args)));
        //$this->categorieid = $args["categorieid"];


        if (!empty($_POST) and (isset($_POST["Enregistrer"]) or (isset($_POST["Enregistrernew"]))))
        {
            //die(var_dump($_POST));
            //$this->oeuvreid = $_POST["id"];
            $this->catid = $_POST["tricategories"];
            $this->oeuvretitre = htmlspecialchars($_POST["titre"]);
            //$this->oeuvredescription = nl2br(html_entity_decode(htmlspecialchars($_POST["description"])));
            $this->oeuvredescription = htmlspecialchars($_POST["description"]);
            $this->actulien = htmlspecialchars($_POST["lien"]);

            
            if (isset($_FILES['fichier']) and !empty($_FILES['fichier']['name']))
            {
                //on définit le nom du fichier photo
                $this->titre_modif = $this->oeuvretitre;
                $this->titre_modif = strtolower($this->titre_modif); // on passe la chaine de caractère du titre article en minuscule
                $this->titre_modif = strtr($this->titre_modif, "àäåâôöîïûüéè", "aaaaooiiuuee"); // on remplace les accents
                $this->titre_modif = str_replace(' ', '-', $this->titre_modif); // on remplace les espaces par des tirets
                //die(var_dump($_FILES['fichier']));
                //$this->nrphoto = $this->oeuvreid;
                $this->nxlien = htmlspecialchars($_FILES['fichier']['name']);
                $this->oeuvrelien = $this->nxlien; 
                $this->nomOrigine = $_FILES['fichier']['name'];
                $this->elementsChemin = pathinfo($this->nomOrigine);
                $this->extensionFichier = $this->elementsChemin['extension'];
                $this->extensionsAutorisees = array("jpg", "JPG", "jpeg", "png", "PNG", "gif");
                if (!(in_array($this->extensionFichier, $this->extensionsAutorisees)))
                {
                    $this->alerte = "Le fichier n'a pas l'extension attendue";
                }
                
                else
                {
                    // Copie dans le repertoire du script avec un nom
                    // incluant l'heure a la seconde pres 
                    $this->repertoireDestination = "imagesoeuvres" . "/";
                    $this->nomDestination = $this->titre_modif . "_" .  date("YmdHis") . "." . $this->extensionFichier;
                    $this->oeuvrelien = $this->nomDestination;
                    //die(var_dump($this->oeuvrelien));

                    if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $this->repertoireDestination . $this->nomDestination))
                    {
                        $this->alerte = "La nouvelle oeuvre a bien été ajouté au catalogue !";
                        //$this->alerte ="Le fichier temporaire " . $_FILES["fichier"]["tmp_name"] .
                        //" a été déplacé vers " . $this->repertoireDestination . $this->nomDestination;
                    }
                        
                    else
                    {
                        $this->alerte = "Le fichier n'a pas été chargé (trop gros ?) ou " .
                        "Le déplacement du fichier temporaire a échoué" .
                        " vérifiez l'existence du répertoire " . $this->repertoireDestination;
                    }
                    
                }
            }
            else 
            {
                $this->oeuvrelien = $this->actulien;
            }


            if(!empty($_POST)and !empty($_POST["titre"]) and isset($_POST["Enregistrer"]))
            {
                $this->oeuvreid = $_POST["id"];
                $this->dataoeuvre = $this->modeloeuvre->modifoeuvre($this->catid, $this->oeuvretitre, $this->oeuvredescription, $this->oeuvrelien, $this->oeuvreprix, $this->oeuvrestatut, $this->oeuvreid); // Appel d'une fonction de cet objet
                $this->alerte = "L'oeuvre a bien été modifiée ";
            }
            else {
                $this->alerte = "L'oeuvre doit avoir un titre ";
            }
            if(!empty($_POST) and !empty($_POST["titre"]) and isset($_POST["Enregistrernew"]))
            {
                //die(var_dump($_POST));
                $this->dataoeuvre = $this->modeloeuvre->createoeuvre($this->catid, $this->oeuvretitre, $this->oeuvredescription, $this->oeuvrelien, $this->oeuvreprix, $this->oeuvrestatut);
                $this->alerte = "L'oeuvre a bien été créée ";
            }
            else {
                $this->alerte = "L'oeuvre doit avoir un titre ";
            }
        }
        elseif (!empty($_POST) and isset($_POST["Supprimer"]))
        {
            unlink("imagesoeuvres/" . $_POST["lien"]);
            $this->oeuvreid = $_POST["id"];
            $this->dataoeuvre = $this->modeloeuvre->deleteoeuvre($this->oeuvreid);
        } 
        

        
        //die(var_dump($this->dataartiste));
        $this->data = $this->modeloeuvre->readlistoeuvres();
        //var_dump($this->data);
        $this->datacat = $this->modeloeuvre->readlistcat();
        $this->template = 'Viewlistoeuvreedit.twig';


    }  

    

    public function actualite()
    {
        $this->titre = "Actualités";
        $this->dataactualite = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //(var_dump($this->data));
        $this->template = 'Viewlistactualite.twig';
    }

    public function actualiteedit()
    {
        $this->titre = "Actualités - admin";

        if (!empty($_POST) and (isset($_POST["Enregistrer"]) or (isset($_POST["Enregistrernew"])))) {
            //die(var_dump($_POST));
            //$this->oeuvreid = $_POST["id"];
            $this->actualitetitre = htmlspecialchars($_POST["titre"]);
            $this->actualitedate = htmlspecialchars($_POST["date"]);
            //$this->oeuvredescription = nl2br(html_entity_decode(htmlspecialchars($_POST["description"])));
            $this->actualitedescription = htmlspecialchars($_POST["description"]);
            $this->actulien = htmlspecialchars($_POST["lien"]);


            if (isset($_FILES['fichier']) and !empty($_FILES['fichier']['name'])) {
                //on définit le nom du fichier photo
                $this->titre_modif = $this->actualitetitre;
                $this->titre_modif = strtolower($this->titre_modif); // on passe la chaine de caractère du titre article en minuscule
                $this->titre_modif = strtr($this->titre_modif, "àäåâôöîïûüéè", "aaaaooiiuuee"); // on remplace les accents
                $this->titre_modif = str_replace(' ', '-', $this->titre_modif); // on remplace les espaces par des tirets
                //die(var_dump($this->titre_modif));
                //$this->nrphoto = $this->oeuvreid;
                $this->nxlien = htmlspecialchars($_FILES['fichier']['name']);
                $this->actualitelien = $this->nxlien;
                $this->nomOrigine = $_FILES['fichier']['name'];
                $this->elementsChemin = pathinfo($this->nomOrigine);
                $this->extensionFichier = $this->elementsChemin['extension'];
                $this->extensionsAutorisees = array("jpg", "JPG", "jpeg", "png", "PNG", "gif");
                if (!(in_array($this->extensionFichier, $this->extensionsAutorisees))) {
                    $this->alerte = "Le fichier n'a pas l'extension attendue";
                } else {
                    // Copie dans le repertoire du script avec un nom
                    // incluant l'heure a la seconde pres 
                    $this->repertoireDestination = "imagesactu" . "/";
                    $this->nomDestination = $this->titre_modif . "_" .  date("YmdHis") . "." . $this->extensionFichier;
                    $this->actualitelien = $this->nomDestination;
                    //die(var_dump($this->actualitelien));

                    if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $this->repertoireDestination . $this->nomDestination)) {
                        $this->alerte = "La nouvelle actualité a bien été ajoutée au catalogue !";
                        //$this->alerte ="Le fichier temporaire " . $_FILES["fichier"]["tmp_name"] .
                        //" a été déplacé vers " . $this->repertoireDestination . $this->nomDestination;
                    } else {
                        $this->alerte = "Le fichier n'a pas été uploadé (trop gros ?) ou " .
                        "Le déplacement du fichier temporaire a échoué" .
                        " vérifiez l'existence du répertoire " . $this->repertoireDestination;
                    }
                }
            } else {
                $this->actualitelien = $this->actulien;
            }


            if (!empty($_POST) and !empty($_POST["titre"]) and isset($_POST["Enregistrer"])) {
                $this->actualiteid = $_POST["id"];
                //die(var_dump($_POST));
                $this->dataactualite = $this->modelactualite->modifactualite($this->actualitetitre, $this->actualitedescription, $this->actualitelien, $this->actualiteid); // Appel d'une fonction de cet objet
                $this->alerte = "L'actualité a bien été modifiée ";
            } else {
                $this->alerte = "L'actualité doit avoir un titre ";
            }
            if (!empty($_POST) and !empty($_POST["titre"]) and isset($_POST["Enregistrernew"])) {
                //die(var_dump($_POST));
                
                $this->dataactualite = $this->modelactualite->createactualite($this->actualitetitre, $this->actualitedescription, $this->actualitelien);
                $this->alerte = "L'actualité a bien été créée ";
            } else {
                $this->alerte = "L'actualité doit avoir un titre ";
            }
        } elseif (!empty($_POST) and isset($_POST["Supprimer"])) {

            unlink("imagesactu/" . $_POST["lien"]);
            $this->actualiteid = $_POST["id"];

            $this->dataoeuvre = $this->modelactualite->deleteactualite($this->actualiteid);
        } 


        $this->dataactualite = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //(var_dump($this->dataactualite));
        $this->template = 'Viewlistactualiteedit.twig';
    }


    public function artiste()
    {
        $this->titre = "L' Artiste";
        $this->dataartiste = $this->modelartiste->readoneartiste(); // Appel d'une fonction de cet objet // Appel d'une fonction de cet objet
        //$this->dataartiste["artiste_text"] = nl2br(html_entity_decode(htmlspecialchars($this->dataartiste["artiste_text"])));
        //die(var_dump($this->dataartiste));

        $this->template = 'Viewartiste.twig';
    }

    public function artisteedit()
    {
        $this->titre = "L' Artiste - admin";

        if (!empty($_POST)) {
            $this->titreartist = htmlspecialchars($_POST["titleartiste"]);
            $this->photoartist = htmlspecialchars($_POST["photoartiste"]);
            //$this->textartist = nl2br(html_entity_decode(htmlspecialchars($_POST["textartiste"])));
            $this->textartist = html_entity_decode(htmlspecialchars($_POST["textartiste"]));
            $this->dataartiste = $this->modelartiste->saveartiste($this->titreartist, $this->textartist, $this->photoartist ); // Appel d'une fonction de cet objet


        } 


        $this->dataartiste = $this->modelartiste->readoneartiste(); // Appel d'une fonction de cet objet
        //(var_dump($this->dataartiste));
        $this->template = 'Viewartisteedit.twig';
        
    }

    public function connect()
    {
        $this->titre = "Je me connecte";
        //$this->data = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
       //die(var_dump($_POST));
        

        if (!empty($_POST)) {
            //die(var_dump($_POST));
            $this->pseudo = htmlspecialchars($_POST["pseudo"]);
            $this->password = htmlspecialchars($_POST["mdp"]);
            //die(var_dump($this->password));

            $this->datauser = $this->modeluser->readoneuser($this->pseudo, $this->password); // Appel d'une fonction de cet objet
            //die(var_dump($this->datauser));
            
            if (count($this->datauser) === 1) {
                
                $user= $this->datauser[0];
                $_SESSION["user"] = $user["user_pseudo"];
                $_SESSION["role"] = $user["user_role"];
                $_SESSION["mail"] = $user["user_mail"];

                if (isset($_SESSION['user'])) {
                    $this->session = $_SESSION;

                    //die(var_dump($this->session));
                }
                
                //die(var_dump($_SESSION['user']));
                $this->template = 'Viewaccueil.twig';
            }
            else {
                
                $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                $this->template = 'Viewuser.twig';
            }

        }
        else {
            {
                $this->template = 'Viewuser.twig';
            }
        }
    }

    function deconnect() 
    {

        //$_SESSION = array();
        // Destruction de la session
        // session_destroy();
        // Destruction du tableau de session
        session_unset();
        //session_start();
        unset($_SESSION);
        //unset($this->session);
        $this->session = null;
        
        $this->template = 'Viewaccueil.twig';
    }


    public function connectnew()
    {
        $this->titre = "Je crée mon compte";
        //$this->data = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //die(var_dump($_POST));


        if (!empty($_POST)) {
            //die(var_dump($_POST));
            $this->pseudo = htmlspecialchars($_POST["pseudo"]);
            $this->mail = htmlspecialchars($_POST["mail"]);
            $this->password = htmlspecialchars($_POST["mdp"]);
            $this->role = "client";
            //die(var_dump($this->password));
           
            if ($this->pseudo <> "" && $this->pseudo <> " " && $this->password<>"" && $this->password<>" " && $this->mail <> "" && $this->mail <> " ") {
                $this->datauser = $this->modeluser->createuser($this->pseudo, $this->mail, $this->password, $this->role); // Appel d'une fonction de cet objet
                 //die(var_dump($this->datauser));
                $this->template = 'Viewaccueil.twig';
            } else {
                $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                $this->template = 'Viewusernew.twig';
            }
        } else { {
                //$this->alerte = "Vous n'avez pas complété le formulaire entièrement !!!!";
                $this->template = 'Viewusernew.twig';
            }
        }
    }

    

    public function contact()
    {
        $this->titre = "Me contacter";
        
        //die(var_dump($this->titre));
        if (!empty($_POST)) {
            //die(var_dump($_POST));
            
            $this->nom = htmlspecialchars($_POST["nom"]);
            $this->prenom = htmlspecialchars($_POST["prenom"]);
            $this->mailvisitor = htmlspecialchars($_POST["mail"]);
            $this->message = htmlspecialchars($_POST["demande"]);
            //die(var_dump($this->nom));
/*
            //Create a new PHPMailer instance
            $mail = new phpmailer();
            //Set PHPMailer to use the sendmail transport
            $mail->isSendmail();
            //Set who the message is to be sent from
            $mail->setFrom('nepasrepondre@svp.com', 'First Last');
            //Set an alternative reply-to address
            $mail->addReplyTo('$this->mailvisitor', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress('masson.prive@gmail.com', 'John Doe');
            //Set the subject line
            $mail->Subject = 'PHPMailer sendmail test';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($this->message);
            //Replace the plain text body with one created manually
            $mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            $mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }

 */

            
            /////voici la version Mine 
           
            $headers = "MIME-Version: 1.0\r\n";

            //////ici on détermine le mail en format text 
            $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";

            ////ici on détermine l'expediteur et l'adresse de réponse 
            $headers .= "From: $this->nom <$this->mail>\r\nReply-to : $this->nom <$this->mail>\nX-Mailer:PHP";

            $subject = "Demande sur votre site de $this->nom $this->prenom";
            $destinataire = "masson.prive@gmail.com"; //remplacez "webmaster@votre-site.com" par votre adresse e-mail
            $body = "$this->message";

            if (mail($destinataire, $subject, $body, $headers)) {
                $this->template = 'Viewsendcontact.twig';
            } else {
                echo "Une erreur dans l'envoi du message s'est produite... Veuillez réessayer plus tard...";
            }
                    
            $this->template = 'Viewsendcontact.twig';
        }
        else {
            $this->template = 'Viewcontact.twig';
        }
    }

    
}
