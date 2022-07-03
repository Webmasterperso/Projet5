console.log("ouverture Command");
class Command {
    constructor(conteneur) {

        if (!document.getElementById(conteneur)) return;
        
        
        this.conteneurcommandconnect = document.getElementById(this.conteneurresserv);
        this.btcaddie = document.getElementById(this.btpanier);
        //console.log("btcaddie au chargement =" + this.btcaddie);
        this.putcaddie = document.getElementById("btputcaddie");
        // this.oeuvrepanier = document.getElementById("listeoeuvrespanier");
        this.deletecaddie = document.getElementById("btsupproduitpanier");
        this.indexpanier = 0;
        this.idputincaddie;
        this.prixtotal = 0;
        //this.$_SESSION;
        this.card;
        this.affichecard();

        //this.event();
    }
}