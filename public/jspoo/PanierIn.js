console.log("ouverture PanierIn");
class PanierIn {
    constructor(idLocalStorage) {
        //if (document.getElementById("panier")) {
        this.idLocalStorage = idLocalStorage;
        const ls = localStorage.getItem(idLocalStorage);
        this.conteneurpanierIn = ls === null ? [] : JSON.parse(ls);
        console.log("conterurpanierIn au chargement = " + this.conteneurpanierIn);
        this.conteneurputcadddie = document.getElementById(this.conteneurresserv);
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
        //}
        //this.event();
    }

    pushcard(idOeuvre) {
        console.log("ouverture puscard");
        // this.idputincaddie = this.formulaire.elements.prodId.value;
        //this.prenomform = this.formulaire.elements.prenom.value;
        if (!idOeuvre || typeof (idOeuvre) !== "number") return
        if (this.conteneurpanierIn.includes(idOeuvre)) return alert("vous avez déjà ajouté ce produit dans le panier");
        alert("vous avez ajouter le produit n°" + idOeuvre);
        this.conteneurpanierIn.push(idOeuvre);
        this.#updateCart();
    }

    removecard(idOeuvresup) {
        //alert("vous avez enlever le produit n°" + idOeuvresup);
        var index = this.conteneurpanierIn.indexOf(idOeuvresup);
        
        if(index !==-1) {
            this.conteneurpanierIn.splice(index,1);
            console.log(this.conteneurpanierIn)
        }
        
        this.#updateCart();
        this.affichecard()
    }

    #updateCart() {
        console.log("ouverture updateCart");
        // window.localStorage.setItem("session", this.id_session);
        window.localStorage.setItem(this.idLocalStorage, JSON.stringify(this.conteneurpanierIn));
        //$_SESSION["idproduit"] = this.conteneurpanierIn;

        //console.log("session updatecart =" + $_SESSION["idproduit"]);
        //
    }

    sendPanier() {
        const form = document.createElement("form");
        form.action = "/command";
        form.method = "POST"
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "list";
        input.value = localStorage.getItem(this.idLocalStorage);
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }


    async affichecard() {
        console.log("ouverture affichecard");
        console.log("conteneurpanierIn affichecard = " + this.conteneurpanierIn, typeof this.conteneurpanierIn);
        console.log("taille conteneurpanierIn = " + this.conteneurpanierIn.length);
        this.indexpanier = 0;
        this.prixtotal = 0;
        

        if (this.conteneurpanierIn.length === 0) {
            document.getElementById("listeoeuvrespanier").innerHTML = "<div id= 'divproduitpanierIn" + this.indexpanier + "' class= 'produitpanierIn'>"

                + "<div class='descproduitpanierIn'>"
                + "<ul>"
                + "<li class='idproduitpanierIn'>Votre panier est vide</li>"
                + "<li class='titreproduitpanierIn'><a href='/oeuvrescat/0' title='Galerie' > <em class='fa-solid fa-angles-left'> Choisissez votre oeuvre dans la galerie</em></a></li>"
                //+ "<li class='titreproduitpanierIn'><i class='fa - solid fa - angles - left'></i> Choisissez votre oeuvre</li>"
                + "</ul>"
                + "</div>" 

        }

        const response = await fetch("http://localhost:8888/api/panier", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ data: this.conteneurpanierIn })
        });
        const oeuvresCompleted = await response.json();
        
        
        //console.log("total avant" + this.prixtotal);
        for (const elm of oeuvresCompleted) {
            //console.log("elm = ", elm);
            this.indexpanier = this.indexpanier + 1;
            this.prixtotal =  this.prixtotal + Number(elm.oeuvre_prix);
            

            if (this.indexpanier===1) {
                document.getElementById("listeoeuvrespanier").innerHTML =  /*html*/ `
                <div id='divproduitpanierIn${this.indexpanier}' class='produitpanierIn'>
                    <div class='imgproduitpanierIn'>
                        <img src='/imagesoeuvres/${elm.oeuvre_lien}' alt='image oeuvre' class='imgoeuvrepanier' />
                    </div>
                <div class='descproduitpanierIn'>
                    <ul>
                        <li class='idproduitpanierIn'>Oeuvre n°${elm.oeuvre_id}</li>
                        <li class='titreproduitpanierIn'>${elm.oeuvre_titre}</li>
                    </ul>
                </div>
                <div class='prixproduitpanierIn'>${elm.oeuvre_prix} €</div>
                <div class='btproduitpanierIn'>
                    <i id='btsupproduitpanier' class='fa-regular fa-trash-can' titre='suppprimer le produit du panier'
                        onclick='cart.removecard(${elm.oeuvre_id})'></i>
                </div>
                
                 `

            }
            else {
                document.getElementById("listeoeuvrespanier").innerHTML += "<div id= 'divproduitpanierIn" + this.indexpanier + "' class= 'produitpanierIn'>"

                + "<div class='imgproduitpanierIn'>"
                + "<img src='/imagesoeuvres/" + elm.oeuvre_lien + "' alt='image oeuvre' class='imgoeuvrepanier' />"
                + "</div>"
                + "<div class='descproduitpanierIn'>"
                + "<ul>"
                + "<li class='idproduitpanierIn'>Oeuvre n°" + elm.oeuvre_id + "</li>"
                + "<li class='titreproduitpanierIn'>" + elm.oeuvre_titre + "</li>"
                + "</ul>"
                + "</div>"
                + "<div class='prixproduitpanierIn'>" + elm.oeuvre_prix + " €</div>"
                + "<div class='btproduitpanierIn'>"
                + "<i id ='btsupproduitpanier' class='fa-regular fa-trash-can' titre = 'suppprimer le produit du panier' onclick = 'cart.removecard(" + elm.oeuvre_id + ")'></i>"
                + "</div>"
                + "</div>";
            }
        }

        document.getElementById("bilanpanier").innerHTML = "<div class='titrebilanpanier'><h2>Récapitulatif</h2></div>"
            + "<ul>"
            + "<li class='idnbrarticle'>Vous avez sélectionné " + this.conteneurpanierIn.length + " oeuvre(s)</li>"
            + "<li class='prixtotalpanier1'>pour un </li>"
            + "<li class='prixtotalpanier2'> Total de " + this.prixtotal + " €</li>"
            + "</ul>"
            + "<div id='horsligne-button-container' titre = 'valider la commande' onclick = 'cart.sendPanier()'>Valider la commande</div>";
    }


}
