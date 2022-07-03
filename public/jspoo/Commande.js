console.log("ouverture Commande");
class Commande {
    constructor(conteneur) {

        if (document.getElementById(conteneur)) {
            this.divcomclient = document.getElementById("commandeclient");
            //this.divadressfac = document.getElementById("adressfactu");
            //this.divadressexpe = document.getElementById("adressexpe");
            //this.checkexpe = document.getElementById("adressportid");
            //this.btvalidadressfac = document.getElementById("Modifierfacid");
            //this.btvalidadressexp = document.getElementById("Modifierexpid");
            this.divpaiement = document.getElementById("paiement");
            this.bthorligne = document.getElementById("horsligne-button-container");
            //this.input = document.querySelector("adressfactu input");
            //this.adressfacturation;
            console.log("bouton paiement hors ligne " + this.bthorligne);
            this.events();
        }
    }
    
    

    affichageadressexpe() {
        //console.log("case à cocher adresse est maintenant egal à : " + this.checkexpe.checked);
        if (this.checkexpe.checked === true) {
            this.divadressexpe.style.display = "block";
        }
        else {
            this.divadressexpe.style.display = "none";
        }
    }

    affichagepaiement() {
        //console.log("case à cocher adresse est maintenant egal à : " + this.checkexpe.checked);
        if (this.checkexpe.checked === true) {
            this.divadressexpe.style.display = "block";
        }
        else {
            this.divadressexpe.style.display = "none";
        }
    }
    
    validCommand() {
        //console.log("adressfacturation :" + adressfacturation.nomfac);
        //this.divadressfac.style.display = "none";
        //this.divadressexpe.style.display = "none";
        this.divcomclient.style.display = "block";
        
    }




    events() {
        
        //this.checkexpe.addEventListener("change", this.affichageadressexpe.bind(this));
        this.bthorligne.addEventListener("click", this.validCommand.bind(this));

        /*this.goleft.addEventListener("click", this.prevdiapo.bind(this));

        //this.gopause.addEventListener("click", this.pause.bind(this));

        document.addEventListener("keydown", this.clavier.bind(this));
        */


    }


}