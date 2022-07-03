class DiversObjet {
    constructor(conteneur) {

        if (document.getElementById(conteneur)) {
            this.divmdp = document.getElementById("mdp");
            this.btmdp = document.getElementById("mail");
            
            
            
            //console.log("case à cocher est egal à : " + this.divdemande);
            //this.document;
            //this.affichage();
            this.events();
        }
    }

    affichagemdp() {
        console.log("case à cocher est maintenant egal à : " + this.envoiphoto.checked);
        if (this.envoiphoto.checked === true) {
            this.divchoixphoto.style.display = "block";
            this.divdemande.innerHTML = "Détaillez le plus possible l'oeuvre souhaitée (taille, noir et blanc ou couleur,exigences diverses...) : </br>";
        }
        else{
            this.divchoixphoto.style.display = "none";
            this.divdemande.innerHTML = "Votre demande :</br>";
        }
        
        /*if (this.tempo !== null) {
            this.tempo = setInterval(this.nextdiapo.bind(this), this.timeschgmt);
        }
        document.getElementById("diapo" + this.index).style.display = "flex";*/
    }




    /*nextdiapo() {
        document.getElementById("diapo" + this.index).style.display = "none";
        if (this.index >= this.nbrimages) { this.index = 0; }
        this.index++;
        document.getElementById("diapo" + this.index).style.display = "flex";
        //this.affichage();

        currentJauge = this.index;
        updateJauge();
    }

    prevdiapo() {
        document.getElementById("diapo" + this.index).style.display = "none";
        if (this.index <= 1) { this.index = this.nbrimages + 1; }
        this.index--;
        document.getElementById("diapo" + this.index).style.display = "flex";
        //this.affichage();
        currentJauge = this.index;
        updateJauge();
    }

    /*pause() {
        if (this.tempo !== null) {
            clearTimeout(this.tempo);
            this.tempo = null;
            this.gopause.innerHTML = "<i class=\"fas fa-play-circle\"></i>";
        }
        else {
            this.gopause.innerHTML = "<i class=\"fas fa-pause-circle\"></i>";
            this.tempo = setInterval(this.nextdiapo.bind(this), this.timeschgmt);
        }
    }*/

    /*clavier(touche) {
        if (touche.key === "ArrowLeft") { this.prevdiapo(); }
        if (touche.key === "ArrowRight") { this.nextdiapo(); }
    }*/

    events() {
        this.envoiphoto.addEventListener("change", this.affichagephotocontact.bind(this));

        /*this.goleft.addEventListener("click", this.prevdiapo.bind(this));

        //this.gopause.addEventListener("click", this.pause.bind(this));

        document.addEventListener("keydown", this.clavier.bind(this));
*/


    }


}
