<?php

namespace App\Controllers;

use App\Models\Modeloeuvres as modeloeuvres;
use App\Models\Modelactualites as modelactualites;
use App\Models\Modelusers as modelusers;
use App\Models\Modelartiste as modelartiste;
use App\Models\Modelcaddie as modelcaddie;
use DateTime;

//use phpmailer\phpmailer\PHPMailer as phpmailer;
//use PHPMailer\PHPMailer\SMTP;

//require __DIR__ . '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Control
{

    public $template = null;
    public $titre = null;
    public $alerte = null;
    public $data = null;
    public $modeloeuvre = null;
    public $status = 200;
    public $data1 = null;
    public $rangcat = null;
    public $rangprix = null;
    public $curseur = 0;
    public $rangcourant;
    public $datacat = null;
    public $nrcat = null;
    public $datauser = null;
    public $dataartiste = null;
    public $dataactualite = null;
    public $datacaddie = null;
    public $datacommand = null;
    public $listcommand = null;
    public $nom = null;
    public $prenom = null;
    public $list = [];
    public $mailvisitor = null;
    public $message = null;
    public $session = null;
    public $nomOrigine = null;
    public $elementsChemin = null;
    public $extensionFichier = null;
    public $extensionsAutorisees = null;
    public $oeuvreId =[];
    public $catId = null;
    public $id = null;
    public $adressexpedition = [];
    public $adressfacturation = [];
    public $paypalId;
    



    public function __construct($args)
    {
        $this->modeloeuvre = new modeloeuvres(); // Création d'un objet
        $this->modelactualite = new modelactualites();
        $this->modeluser = new modelusers();
        $this->modelartiste = new modelartiste();
        $this->modelcaddie = new modelcaddie();

        if (isset($_SESSION)) {
            //$_SESSION["id"] = $_COOKIE['PHPSESSID'];
            //$_SESSION["id"] = session_id();
            $this->session = $_SESSION;
            
            //die(var_dump($_SESSION['user']));
            //die(var_dump($_COOKIE['PHPSESSID']));
           //die(var_dump($this->session));
        }


        if (count($args) === 0) {
            return $this->accueil();
            //die(var_dump($dataform));
        }

        if (count($args) === 1) {

            if (method_exists($this, $args["nomPage"])) {
                //die(var_dump($args));
                $nomfoncion = $args["nomPage"];
                //die(var_dump($nomfoncion));
                //return $this->session();
                return $this->$nomfoncion();
                //return $this->oeuvres();
            }
        }

        if (count($args) === 2) {
            //die(var_dump($args));
            if (method_exists($this, $args["nomPage"])) {
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

            die(var_dump($this->session));
        }
    }

    public function accueil()
    {
        $this->titre = "Bienvenue dans l'univers d'Anne Madamet, artiste peintre...!";
        //$this->data = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        $this->datacat = $this->modeloeuvre->readlistcat();
        $this->dataactualite = $this->modelactualite->readlistactualite();
        //die(var_dump($this->datacat));
        $this->template = 'Viewaccueil.twig';
    }

    public function oeuvres()
    {
        $this->titre = "Les oeuvres de l'artiste";
        $this->data = $this->modeloeuvre->readlistoeuvres(); // Appel d'une fonction de cet objet
        $this->datacat = $this->modeloeuvre->readlistcat();
        //die(var_dump($this->data));
        $this->template = 'Viewlistoeuvre.twig';
    }

    public function oeuvrescat($args)
    {
        $this->titre = "Les oeuvres de l'artiste";
        $this->rangcat = $args["categorieid"];
        if ($args["categorieid"] == 0) {
            $this->data = $this->modeloeuvre->readlistoeuvres();
            //die(var_dump($this->data));
        } else {
            $this->data = $this->modeloeuvre->readoeuvrebycat($args["categorieid"]);
        }

        $this->datacat = $this->modeloeuvre->readlistcat();
        //die(var_dump($this->data));
        if (isset($_SESSION["role"]) and $_SESSION["role"] == "admin") {
            $this->template = 'Viewlistoeuvreedit.twig';
        } else {
            $this->template = 'Viewlistoeuvre.twig';
        }
    }

    public function oeuvre($args)
    {
        $this->titre = "Details des oeuvres";
        if ($args["categorieid"] != 0) {
            $this->titre = "Details des oeuvres";

            $this->data = $this->modeloeuvre->readoeuvrebycat($args["categorieid"]);
            $this->datacat = $this->modeloeuvre->readonecat($args["categorieid"]);

            //die(var_dump($this->data));
        } else {
            //die(var_dump($this->data));
            $this->data = $this->modeloeuvre->readlistoeuvres();
            $this->datacat = $this->modeloeuvre->readlistcat();
            $this->titre = "Details de toutes les oeuvres";
        }
        $this->data1 = $this->modeloeuvre->readoneoeuvre($args["idOeuvre"]);

        //die(var_dump($this->datacat));
        //if (isset($_SESSION)) {
            //$this->sessions = $_SESSION;
            //die(var_dump($_SESSION['user']));
            //die(var_dump($this->session));
        //}

        //$this->rang = array_search($this->data1[0], $this->data );
        $this->template = 'Viewoneoeuvre.twig';
    }

    public function oeuvreedit()
    {
        $this->titre = "Vos Oeuvres - Admin";
        //die(var_dump(count($args)));
        //$this->categorieid = $args["categorieid"];


        if (!empty($_POST) and (isset($_POST["Enregistrer"]) or (isset($_POST["Enregistrernew"])))) {
            //die(var_dump($_POST));
            //$this->oeuvreid = $_POST["id"];
            $this->catid = $_POST["tricategories"];
            $this->oeuvretitre = htmlspecialchars($_POST["titre"]);
            //$this->oeuvredescription = nl2br(html_entity_decode(htmlspecialchars($_POST["description"])));
            $this->oeuvredescription = htmlspecialchars($_POST["description"]);
            $this->oeuvreprix = htmlspecialchars($_POST["prix"]);
            $this->oeuvrestatut = htmlspecialchars($_POST["statut"]);
            $this->actulien = htmlspecialchars($_POST["lien"]);


            if (isset($_FILES['fichier']) and !empty($_FILES['fichier']['name'])) {
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
                if (!(in_array($this->extensionFichier, $this->extensionsAutorisees))) {
                    $this->alerte = "Le fichier n'a pas l'extension attendue";
                } else {
                    // Copie dans le repertoire du script avec un nom
                    // incluant l'heure a la seconde pres 
                    $this->repertoireDestination = "imagesoeuvres" . "/";
                    $this->nomDestination = $this->titre_modif . "_" .  date("YmdHis") . "." . $this->extensionFichier;
                    $this->oeuvrelien = $this->nomDestination;
                    //die(var_dump($this->oeuvrelien));

                    if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $this->repertoireDestination . $this->nomDestination)) {
                        $this->alerte = "La nouvelle oeuvre a bien été ajouté au catalogue !";
                        //$this->alerte ="Le fichier temporaire " . $_FILES["fichier"]["tmp_name"] .
                        //" a été déplacé vers " . $this->repertoireDestination . $this->nomDestination;
                    } else {
                        $this->alerte = "Le fichier n'a pas été chargé (trop gros ?) ou " .
                            "Le déplacement du fichier temporaire a échoué" .
                            " vérifiez l'existence du répertoire " . $this->repertoireDestination;
                    }
                }
            } else {
                $this->oeuvrelien = $this->actulien;
            }


            if (!empty($_POST) and !empty($_POST["titre"]) and isset($_POST["Enregistrer"])) {
                $this->oeuvreid = $_POST["id"];
                $this->dataoeuvre = $this->modeloeuvre->modifoeuvre($this->catid, $this->oeuvretitre, $this->oeuvredescription, $this->oeuvrelien, $this->oeuvreprix, $this->oeuvrestatut, $this->oeuvreid); // Appel d'une fonction de cet objet
                $this->alerte = "L'oeuvre a bien été modifiée ";
            } else {
                $this->alerte = "L'oeuvre doit avoir un titre ";
            }
            if (!empty($_POST) and !empty($_POST["titre"]) and isset($_POST["Enregistrernew"])) {
                //die(var_dump($_POST));
                $this->dataoeuvre = $this->modeloeuvre->createoeuvre($this->catid, $this->oeuvretitre, $this->oeuvredescription, $this->oeuvrelien, $this->oeuvreprix, $this->oeuvrestatut);
                $this->alerte = "L'oeuvre a bien été créée ";
            } else {
                $this->alerte = "L'oeuvre doit avoir un titre ";
            }
        } elseif (!empty($_POST) and isset($_POST["Supprimer"])) {
            unlink("imagesoeuvres/" . $_POST["lien"]);
            $this->oeuvreid = $_POST["id"];
            $this->dataoeuvre = $this->modeloeuvre->deleteoeuvre($this->oeuvreid);
        }

        

        //die(var_dump($this->dataartiste));
        $this->data = $this->modeloeuvre->readlistoeuvres();
        //var_dump($this->data);
        $this->datacat = $this->modeloeuvre->readlistcat();

        if (isset($_SESSION["user"]) and $_SESSION["role"] == "admin") {
            $this->template = 'Viewlistoeuvreedit.twig';
        } else {
            $this->titre = "Les oeuvres";
            $this->template = 'Viewlistoeuvre.twig';
        }
    }

    public function actualite()
    {
        $this->titre = "Actualités de l'artiste";
        $this->dataactualite = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //(var_dump($this->data));
        $this->template = 'Viewlistactualite.twig';
    }

    public function actualiteedit()
    {
        $this->titre = "Vos Actualités - admin";

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
        if (isset($_SESSION["user"]) and $_SESSION["role"] == "admin") {
            $this->template = 'Viewlistactualiteedit.twig';
        } else {
            $this->titre = "Les actualités";
            $this->template = 'Viewlistactualite.twig';
        }

        
    }

    public function artiste()
    {
        $this->titre = "Biographie de l' Artiste";
        $this->dataartiste = $this->modelartiste->readoneartiste(); // Appel d'une fonction de cet objet // Appel d'une fonction de cet objet
        //$this->dataartiste["artiste_text"] = nl2br(html_entity_decode(htmlspecialchars($this->dataartiste["artiste_text"])));
        //die(var_dump($this->dataartiste));

        $this->template = 'Viewartiste.twig';
    }

    public function artisteedit()
    {
        $this->titre = "Votre biographie - admin";

        if (!empty($_POST)) {
            $this->titreartist = htmlspecialchars($_POST["titleartiste"]);
            $this->photoartist = htmlspecialchars($_POST["photoartiste"]);
            //$this->textartist = nl2br(html_entity_decode(htmlspecialchars($_POST["textartiste"])));
            $this->textartist = html_entity_decode(htmlspecialchars($_POST["textartiste"]));
            $this->dataartiste = $this->modelartiste->saveartiste($this->titreartist, $this->textartist, $this->photoartist); // Appel d'une fonction de cet objet


        }


        $this->dataartiste = $this->modelartiste->readoneartiste(); // Appel d'une fonction de cet objet
        //(var_dump($this->dataartiste));
        $this->template = 'Viewartisteedit.twig';
    }

    public function connect()
    {
        $this->titre = "Je me connecte à mon compte";

        if (!empty($_POST)) {
            //die(var_dump($_POST));
            $this->pseudo = htmlspecialchars($_POST["pseudo"]);
            $this->password = htmlspecialchars($_POST["mdp"]);
            //$this->pass_hache = password_hash($this->password, PASSWORD_DEFAULT);
            //die(var_dump($this->pass_hache));

            $this->datauser = $this->modeluser->readoneuser($this->pseudo); // Appel d'une fonction de cet objet
            //die(var_dump($this->datauser));

            if (count($this->datauser) === 1) {
                
                $user = $this->datauser[0];
                //die(var_dump($user));
                $isPasswordok = password_verify($this->password, $user["user_mdp"]);
                if($isPasswordok){
                    $_SESSION["id"] = $user["user_id"];
                    $_SESSION["user"] = $user["user_pseudo"];
                    $_SESSION["role"] = $user["user_role"];
                    $_SESSION["mail"] = $user["user_mail"];
                    $_SESSION["mdp"] = $this->password;
                    $_SESSION["nom"] = $user["user_nom"];
                    $_SESSION["prenom"] = $user["user_prenom"];
                    $_SESSION["adresse"] = $user["user_adresse"];
                    $_SESSION["cp"] = $user["user_cp"];
                    $_SESSION["ville"] = $user["user_ville"];
                    $_SESSION["telephone"] = $user["user_telephone"];

                    $this->session = $_SESSION;
                //die(var_dump($_SESSION));
                    $this->titre = "Mon profil";
                    $this->template = 'Viewprofil.twig';
                }
                else {
                    $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                    $this->template = 'Viewuser.twig';
                }
            }
            else {

                $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                $this->template = 'Viewuser.twig';
            }
        } 
        else {
            
            $this->template = 'Viewuser.twig';
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
        $this->alerte = "Vous avez été déconnecté...";
        $this->titre = "Je me connecte à mon compte";
        $this->template = 'Viewuser.twig';
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
            $this->pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $this->nom = htmlspecialchars($_POST["nom"]);
            $this->prenom = htmlspecialchars($_POST["prenom"]);
            $this->adresse = htmlspecialchars($_POST["adresse"]);
            $this->cp = htmlspecialchars($_POST["cp"]);
            $this->ville = htmlspecialchars($_POST["ville"]);
            $this->telephone = htmlspecialchars($_POST["telephone"]);
            $this->role = "client";
            //die(var_dump($this->password));

            if ($this->pseudo <> "" && $this->pseudo <> " " && $this->password <> "" && $this->password <> " " && $this->mail <> "" && $this->mail <> " ") {
                $this->datauser = $this->modeluser->createuser($this->pseudo, $this->nom, $this->prenom, $this->mail, $this->pass_hache, $this->role, $this->adresse, $this->cp, $this->ville, $this->telephone); // Appel d'une fonction de cet objet
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

    public function connectprofil()
    {
        $this->titre = "mon compte";
        //$this->data = $this->modelactualite->readlistactualite(); // Appel d'une fonction de cet objet
        //die(var_dump($_POST));


        if (!empty($_POST)) {
            //die(var_dump($_POST));
            //$this->id = htmlspecialchars($_POST["nmrclient"]);
            $this->id = $this->session["id"];
            $this->pseudo = htmlspecialchars($_POST["pseudo"]);
            $this->mail = htmlspecialchars($_POST["mail"]);
            $this->password = htmlspecialchars($_POST["mdp"]);
            $this->pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $this->nom = htmlspecialchars($_POST["nom"]);
            $this->prenom = htmlspecialchars($_POST["prenom"]);
            $this->adresse = htmlspecialchars($_POST["adresse"]);
            $this->cp = htmlspecialchars($_POST["cp"]);
            $this->ville = htmlspecialchars($_POST["ville"]);
            $this->telephone = htmlspecialchars($_POST["telephone"]);
            $this->role = $this->session["role"];
            //die(var_dump($this->id));

            if ($this->pseudo <> "" && $this->pseudo <> " " && $this->password <> "" && $this->password <> " " && $this->mail <> "" && $this->mail <> " ") {
                $this->datachangeuser = $this->modeluser->modifuser($this->pseudo, $this->nom, $this->prenom, $this->mail, $this->pass_hache, $this->role, $this->adresse, $this->cp, $this->ville, $this->telephone, $this->id); // Appel d'une fonction de cet objet
                //die(var_dump($this->datauser));
                $_SESSION["id"] = $this->session["id"];
                $_SESSION["user"] = $this->pseudo;
                $_SESSION["role"] = $this->role;
                $_SESSION["mail"] = $this->mail;
                $_SESSION["mdp"] = $this->password;
                $_SESSION["nom"] = $this->nom;
                $_SESSION["prenom"] = $this->prenom;
                $_SESSION["adresse"] = $this->adresse;
                $_SESSION["cp"] = $this->cp;
                $_SESSION["ville"] = $this->ville;
                $_SESSION["telephone"] = $this->telephone;

                if (isset($_SESSION['user'])) {
                    $this->session = $_SESSION;

                    //die(var_dump($this->session));
                }
                $this->alerte = "Votre profil a bien été modifié !!!!";
                $this->template = 'Viewprofil.twig';
            }
            else {
                $this->alerte = "Un des champs obligatoires est vide ou mal rempli !!!!";
                $this->template = 'Viewprofil.twig';
            }
        }
        else {
            if (isset($this->session) and (!empty($this->session))) {
                //die(var_dump($_SESSION));
                //$this->alerte = "Vous n'avez pas complété le formulaire entièrement !!!!";
                $this->template = 'Viewprofil.twig';
            }
            else {
                $this->template = 'Viewuser.twig';
            }
        }
        
    }

    function contact()
    {
        $this->titre = "Me contacter";
        //die(var_dump($this->titre));
        if (!empty($_POST)) {
            $mail = new PHPMailer(true);

            try {
                $this->nom = htmlspecialchars($_POST["nom"]);
                $this->prenom = htmlspecialchars($_POST["prenom"]);
                $this->mailvisitor = htmlspecialchars($_POST["mail"]);
                // $this->choixphoto = htmlspecialchars($_POST["choixphoto"]);
                $this->message = htmlspecialchars($_POST["demande"]);

                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_ENV["SMTP_HOST"];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $_ENV["SMTP_Username"];                     //SMTP username
                $mail->Password   = $_ENV["SMTP_Password"];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = $_ENV["SMTP_Port"];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($_ENV["SMTP_SENDER"], 'Site Anne Madamet');
                $mail->addAddress($_ENV["ANNE_EMAIL"], 'Admin');     //Add a recipient
                $mail->addReplyTo($this->mailvisitor, "$this->nom $this->prenom");
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                $mail->addAttachment($_FILES["choixphoto"]["tmp_name"], $_FILES["choixphoto"]["name"]);         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Contact site Anne Madamet';
                $mail->Body    = $this->message;
                $mail->AltBody = $this->message;

                $mail->send();
                
                $this->template = 'Viewsendcontact.twig';
            } catch (Exception $e) {
                $this->template = 'Viewcontact.twig';
                die(var_dump($mail->ErrorInfo));
            }
        } else {
            $this->template = 'Viewcontact.twig';
        }
    }

    public function panier()
    {
        $this->titre = "Mon panier";
        $this->template = 'Viewpanier.twig';
    }


    public function command()
    {
        $this->paypalId = $_ENV["PAYPALID"];

        if (!empty($_POST) and !empty($_POST["list"])) {
            $this->titre = "Ma commande en cours";
            //die(var_dump($_POST));
            
            $this->listcommand = [];
            $this->listcommand = htmlspecialchars($_POST["list"]);
            //die(var_dump($this->listcommand));
            $this->listcommand1 = str_replace(array("[", "]"), '', $this->listcommand);
            $this->listcommandarray = explode(",", $this->listcommand1);
            //die(var_dump($this->listcommandarray));
            $this->datacommand = $this->modeloeuvre->getOeuvresIntoCart($this->listcommandarray);
            //die(var_dump($this->datacommand));
            
            $this->template = 'Viewcommand.twig';
        }
        else {
            $this->template = 'Viewpanier.twig';
        }

        if (!empty($_POST["pseudo"]) and !empty($_POST["mdp"])) {
            //die(var_dump($_POST));
            $this->pseudo = htmlspecialchars($_POST["pseudo"]);
            $this->password = htmlspecialchars($_POST["mdp"]);
            //$this->pass_hache = password_hash($this->password, PASSWORD_DEFAULT);
            //die(var_dump($this->pass_hache));

            $this->datauser = $this->modeluser->readoneuser($this->pseudo); // Appel d'une fonction de cet objet
            //die(var_dump($this->datauser));

            if (count($this->datauser) === 1) {
                
                $user = $this->datauser[0];
                //die(var_dump($user));
                $isPasswordok = password_verify($this->password, $user["user_mdp"]);
                if ($isPasswordok) {
                    //$list = $_POST["list"];
                    $_SESSION["id"] = $user["user_id"];
                    $_SESSION["user"] = $user["user_pseudo"];
                    $_SESSION["role"] = $user["user_role"];
                    $_SESSION["mail"] = $user["user_mail"];
                    $_SESSION["mdp"] = $this->password;
                    $_SESSION["nom"] = $user["user_nom"];
                    $_SESSION["prenom"] = $user["user_prenom"];
                    $_SESSION["adresse"] = $user["user_adresse"];
                    $_SESSION["cp"] = $user["user_cp"];
                    $_SESSION["ville"] = $user["user_ville"];
                    $_SESSION["telephone"] = $user["user_telephone"];

                    $this->session = $_SESSION;
                    //die(var_dump($_SESSION));
                    $this->titre = "Ma commande en cours";
                    $this->template = 'Viewcommand.twig';
                } else {
                    $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                    $this->template = 'Viewcommand.twig';
                }
            } else {

                $this->alerte = "Votre pseudo ou/et votre mot de passe ne sont pas valables !!!!";
                $this->template = 'Viewcommand.twig';
            }
        } else {
            $this->template = 'Viewcommand.twig';
        }

        if (!empty($_POST["demandevalcommande"]) and !empty($_POST["nomvalcommandeid"])) {
            $mail = new PHPMailer(true);

            try {
                $this->nom = htmlspecialchars($_POST["nom"]);
                $this->prenom = htmlspecialchars($_POST["prenom"]);
                $this->mailvisitor = htmlspecialchars($_POST["mail"]);
                // $this->choixphoto = htmlspecialchars($_POST["choixphoto"]);
                $this->message = htmlspecialchars($_POST["demande"]);

                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_ENV["SMTP_HOST"];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $_ENV["SMTP_Username"];                     //SMTP username
                $mail->Password   = $_ENV["SMTP_Password"];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = $_ENV["SMTP_Port"];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($_ENV["SMTP_SENDER"], 'Site Anne Madamet');
                $mail->addAddress($_ENV["ANNE_EMAIL"], 'Admin');     //Add a recipient
                $mail->addReplyTo($this->mailvisitor, "$this->nom $this->prenom");
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                $mail->addAttachment($_FILES["choixphoto"]["tmp_name"], $_FILES["choixphoto"]["name"]);         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Contact site Anne Madamet';
                $mail->Body    = $this->message;
                $mail->AltBody = $this->message;

                $mail->send();

                $this->template = 'Viewsendcontact.twig';
            } catch (Exception $e) {
                $this->template = 'Viewcommand.twig';
                die(var_dump($mail->ErrorInfo));
            }
        } else {
            $this->template = 'Viewcommand.twig';
        }
        }
        
        
        /*if (!empty($_POST["nomfac"]) and !empty($_POST["prenomfac"])) {
            $this->adressfacturation = [];
            $this->adressfacturation["nomfac"] = $_POST["nomfac"];
            $this->adressfacturation["prenomfac"] = $_POST["prenomfac"];
            $this->adressfacturation["adressefac"] = $_POST["adressefac"];
            $this->adressfacturation["cpfac"] = $_POST["cpfac"];
            $this->adressfacturation["villefac"] = $_POST["villefac"];
            $this->adressfacturation["mailfac"] = $_POST["mailfac"];
            $this->adressfacturation["telephonefac"] = $_POST["telephonefac"];
            $this->adressfacturation["validadressfac"] = $_POST["Modifierfac"];
          
            if (!isset($_POST["adressport"])) {
                $this->adressexpedition = [];
                $this->adressexpedition["nomexp"] = $_POST["nomfac"];
                $this->adressexpedition["prenomexp"] = $_POST["prenomfac"];
                $this->adressexpedition["adresseexp"] = $_POST["adressefac"];
                $this->adressexpedition["cpexp"] = $_POST["cpfac"];
                $this->adressexpedition["villeexp"] = $_POST["villefac"];
                $this->adressexpedition["mailexp"] = $_POST["mailfac"];
                $this->adressexpedition["telephoneexp"] = $_POST["telephonefac"];
                $this->adressfacturation["validadressexp"] = $_POST["Modifierfac"];
                //die(var_dump($this->adressexpedition));
            }

            $this->template = 'Viewcommand.twig';  
        }
        //die(var_dump($this->adressfacturation));
        if (!empty($_POST["nomexp"]) and !empty($_POST["prenomexp"])) {
            //die(var_dump($this->adressfacturation));
            $this->adressexpedition = [];
            $this->adressexpedition["nomexp"] = $_POST["nomexp"];
            $this->adressexpedition["prenomexp"] = $_POST["prenomexp"];
            $this->adressexpedition["adresseexp"] = $_POST["adresseexp"];
            $this->adressexpedition["cpexp"] = $_POST["cpexp"];
            $this->adressexpedition["villeexp"] = $_POST["villeexp"];
            $this->adressexpedition["mailexp"] = $_POST["mailexp"];
            $this->adressexpedition["telephoneexp"] = $_POST["telephoneexp"];
            $this->adressfacturation["validadressexp"] = $_POST["Modifierexp"];
            //die(var_dump($this->adressexpedition));
            $this->template = 'Viewcommand.twig';
        }*/
    }
}