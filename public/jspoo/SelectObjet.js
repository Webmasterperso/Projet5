console.log("ouverture SelectObjet");

class SelectObjet {
    constructor(conteneur) {

        if (document.getElementById(conteneur)) {
        this.obj = document.getElementsByClassName("tricategories");
        this.url = document.location.href
        this.varindex=0;
        
        this.events();
        }
    }

    events()
    {
       
        if (this.obj) {
            console.log("ouverture SelectObjet events this objet");
            this.obj.tricategories.addEventListener('change', (event) => {
            //console.log("ouverture SelectObjet events change");
                this.varindex = event.target.value; 
                //sessionStorage.setItem('cat', event.target.value);
                document.location.href = "/oeuvrescat/" + event.target.value;

                for (i = 0; i < this.obj.length; i++) {
                    if (i == event.target.value){
                        this.obj.options[i].selected = true;}
                    else {
                        this.obj.options[i].selected = false;
                    }

                
                }    
            });
        }
    }
}
