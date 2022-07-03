console.log("ouverture SelectObjet");

class SelectObjet {
    constructor(conteneur) {

        if (!document.getElementById(conteneur)) return;

        this.list = this.extractOeuvres();
        this.nbrelms = 0;
        this.objcat = document.getElementById("tricategories");
        this.objprix = document.getElementById("yearRangeSelector");
        this.detailtripri = document.getElementById("detail-tri-prix");
        //this.nbrlimite = document.getElementById(conteneur).getElementsByClassName("range-input").length;
        //this.objprix = document.getElementsByClassName("range-input-label");
        this.url = document.location.href;
        this.varindex = 0;
        //this.priminimum = null;
        //this.primin = document.querySelector('#min');
        //this.primin = document.getElementById('minMaxSlider');
        this.document;
        this.events();
        document.getElementById(conteneur).addEventListener("change", this.handleSlider.bind(this))

    }

    /**
     * @param   {event}  e  
     */
    handleSlider(e) {
        // data = { sliderId: null, minRangeValue: 0, maxRangeValue: 1000 }
        const { minRangeValue, maxRangeValue } = e.detail;
        this.nbrelms = 0;
        for ( const oeuvre of this.list){
            //console.log(minRangeValue, maxRangeValue, oeuvre.price)
            if (oeuvre.price >= minRangeValue && oeuvre.price<= maxRangeValue) { oeuvre.DOM.style.display="block";
                this.nbrelms = this.nbrelms+1;}
            else oeuvre.DOM.style.display = "none";
        }
        //console.log("nbr oeuvre selectionnee" + this.nbrelms);
        if(this.nbrelms===1)
        {this.detailtripri.innerHTML = this.nbrelms + " oeuvre sélectionnée";}
        else
           { this.detailtripri.innerHTML = this.nbrelms + " oeuvres sélectionnées";}
    }

    extractOeuvres(){
        const list =[];
        const elms = document.querySelectorAll(".tableauoeuvre");
        //const nbrelms = elms.length;
        //console.log(nbrelms)
        let price;
        for (const elm of elms){
            price = elm.querySelectorAll("li")[2].innerText;
            price = parseInt(price.slice(0,-1).trim());


            list.push({
                price,
                DOM : elm
            })
        }
        return list;
    }

    events() {

        if (this.objcat) {
            //console.log("ouverture SelectObjet events this objet catégories");
            //console.log("objcat est egal à : " + this.objcat);
            this.objcat.addEventListener('change', (event) => {
                //console.log("ouverture SelectObjet events change");
                this.varindex = event.target.value;
                //sessionStorage.setItem('cat', event.target.value);
                document.location.href = "/oeuvrescat/" + event.target.value;

                for (i = 0; i < this.objcat.length; i++) {
                    if (i == event.target.value) {
                        this.objcat.options[i].selected = true;
                    }
                    else {
                        this.objcat.options[i].selected = false;
                    }


                }
            });
        }

        
        
    }
}

