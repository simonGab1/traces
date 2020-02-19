/**
 * @author Simon-Gabriel Côté-Poulin <simon_gab@outlook.com>
 */


export class AjaxPanierLivraison {

    // ATTRIBUTS
    private modeLivraison = document.querySelector('#livraison');
    private livraison = $('.livraison');
    private jourLivraison = $('.jourLivraison');
    private total = $(".total");
    private livraisonGratuite = $('.gratuite');


    // Constructeur
    constructor() {
        let refThis = this;
        this.modeLivraison.addEventListener("change", function (element) {
            refThis.executerAjax(element);
        });

    }

    public retournerResultat(data) {

        //cacher / afficher le mode de livraison gratuit
        if (data["soustotal"] > 50.00){
            this.livraisonGratuite.removeClass('visuallyhidden');
        }else {
            this.livraisonGratuite.addClass('visuallyhidden');
        }

        this.livraison.html(data["livraison"]);
        this.jourLivraison.html(data["jourLivraison"]);
        this.total.html(data["total"]);
    }

    public executerAjax(element) {
        let modeLivraison = element.currentTarget.value;
        let refThis = this;
        $.ajax({
            url: 'index.php?controleur=panier&action=majLivraisonAjax&modesLivraison=' + modeLivraison,
            type: 'GET',
            dataType: 'json'
        }).done(function (data) {
            refThis.retournerResultat(data);
        }).catch(function (err) {
            console.log(err);
        });

    }

}
