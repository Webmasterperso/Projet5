console.log("ouverture SlideObjetaccueil");

class SlideObjetaccueil {
    constructor(conteneur, timeschgmt) {

        if (document.getElementById(conteneur)) {
            console.log("gelelementbyid is OK");
        this.nbrimages = document.getElementById(conteneur).getElementsByClassName("diapoacc").length; //taille tableau class images
        this.index = 1; //index images
        this.index1 = 2;
        this.index2= 0;
        this.goright = document.getElementById("slideacc_right");
        this.goleft = document.getElementById("slideacc_left");
        this.gopause = document.getElementById("slideacc_pause");
        this.tempo;
        this.timeschgmt = timeschgmt;
        this.document;
        this.affichage();
       
        }
    }
    
    affichage() {
        clearTimeout(this.tempo);
        if (this.tempo !== null) {
            this.tempo = setInterval(this.nextdiapo.bind(this), this.timeschgmt);
        }
    }
    nextdiapo() {
        document.getElementById("diapoacc" + this.index).style.display = "block";
        document.getElementById("diapoacc" + this.index1).style.display = "block";
        console.log("index = " + this.index);
        console.log("index1 = " + this.index1);
        console.log("index2 = " + this.index2);
        if (this.index1 >= this.nbrimages) {
             this.index = 0;
             this.index1 = 1;
            
            document.getElementById("diapoacc" + this.index1).style.display = "block";
        }
        if (this.index2 >= 1 && this.index2 <= 9) {
            console.log("index2 none = " + this.index2);
            document.getElementById("diapoacc" + this.index2).style.display = "none";
        }
        else if (this.index2>0) {
            while (this.index2 <= 11) {
                document.getElementById("diapoacc" + this.index2).style.display = "none";
                this.index2++;
            }
        
            this.index2 = 0
        }
        
        //document.getElementById("diapoacc" + this.index).style.display = "none";
        this.index++;
        this.index1++;
        this.index2++;
        
        
        this.affichage();
    }

    prevdiapo() {
        document.getElementById("diapoacc" + this.index).style.display = "none";
        if (this.index <= 1) { this.index = this.nbrimages + 1; }
        this.index--;
        document.getElementById("diapoacc" + this.index).style.display = "block";
        this.affichage();
    }

    

    clavier(touche) {
        if (touche.key === "ArrowLeft") { this.prevdiapo(); }
        if (touche.key === "ArrowRight") { this.nextdiapo(); }
    }

    


}

