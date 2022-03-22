console.log("ouverture SlideObjet");

class SlideObjet {
    constructor(conteneur) {

        if (document.getElementById(conteneur)){
        this.nbrimages = document.getElementById(conteneur).getElementsByClassName("diapo").length; //taille tableau class images
        
        this.index = 1; //index images
        this.goright = document.getElementById("slide_right");
        this.goleft = document.getElementById("slide_left");
        //this.gopause = document.getElementById("slide_pause");
        //this.tempo;
        //this.timeschgmt = timeschgmt;
        this.document;
        //this.affichage();
        this.events();
        }
    }
    
    affichage() {
        /**clearTimeout(this.tempo);
        if (this.tempo !== null) {
            this.tempo = setInterval(this.nextdiapo.bind(this), this.timeschgmt);
        }
        document.getElementById("diapo" + this.index).style.display = "flex";**/
    }
    nextdiapo() {
        document.getElementById("diapo" + this.index).style.display = "none";
        if (this.index >= this.nbrimages) { this.index = 0; }
        this.index++;
        document.getElementById("diapo" + this.index).style.display = "flex";
        //this.affichage();
    }

    prevdiapo() {
        document.getElementById("diapo" + this.index).style.display = "none";
        if (this.index <= 1) { this.index = this.nbrimages + 1; }
        this.index--;
        document.getElementById("diapo" + this.index).style.display = "flex";
        //this.affichage();
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

    clavier(touche) {
        if (touche.key === "ArrowLeft") { this.prevdiapo(); }
        if (touche.key === "ArrowRight") { this.nextdiapo(); }
    }

    events() {
        this.goright.addEventListener("click", this.nextdiapo.bind(this));

        this.goleft.addEventListener("click", this.prevdiapo.bind(this));

        //this.gopause.addEventListener("click", this.pause.bind(this));

        document.addEventListener("keydown", this.clavier.bind(this));

    }


}

