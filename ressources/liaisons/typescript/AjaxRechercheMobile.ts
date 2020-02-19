/**
 * @author Alexandre Blanchet <alexandre.blanchet.ab@gmail.com>
 */


export class AjaxRechercheMobile {

    // ATTRIBUTS
    private selectCritere: JQuery<HTMLElement> = null;
    private inputRecherche: JQuery<HTMLElement> = null;
    private executerAjax__lier: any = null;


    // Constructeur
    constructor() {

        this.selectCritere = $("#critereMobile");
        this.inputRecherche = $("#mot_cleMobile");

        this.executerAjax__lier = this.executerAjax.bind(this);

        this.inputRecherche.on("focus", this.startKeyUp.bind(this));
        this.inputRecherche.on("focusout", this.stopKeyUp.bind(this));

    }

    public startKeyUp() {
        document.addEventListener('keyup',this.executerAjax__lier);
    }

    public stopKeyUp() {
        let counter = 1;
        let intervalId = setInterval(() => {
            counter = counter - 1;
            if(counter === 0) {
                clearInterval(intervalId)
                $('#rechercheResultatsMobile').html("");
                document.removeEventListener('keyup',this.executerAjax__lier);
            }
        }, 100)


    }

    public retournerResultat(data) {
        let resultat: JQuery<HTMLElement> = $('#rechercheResultatsMobile');
        let listeLivres: string = '';
        if(data == ""){


        } else {
            for(let cpt=0; cpt < data.length ; cpt++){

                listeLivres = listeLivres + '<a href="index.php?controleur=livre&action=fiche&id='+data[cpt]['id']+'"><li>'+data[cpt]['titre']+'</li>';

            };
        }

        resultat.html("<ul>"+listeLivres+"</ul>");

    }

    public executerAjax() {
        let critere: any = this.selectCritere.val();
        let motCle: any = this.inputRecherche.val();


        $.ajax({
            url: 'index.php?controleur=site&action=rechercheAjax&critere=' + critere + "&mot_cle="+ motCle,
            type: 'GET',
            dataType: 'json'
        })
            .done(this.retournerResultat)
            .catch(function (err) {
                console.log(err);
            });
    }

}