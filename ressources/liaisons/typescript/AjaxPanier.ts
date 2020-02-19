/**
 * @author Simon-Gabriel Côté-Poulin <simon_gab@outlook.com>
 */

export class AjaxPanier {

    // ATTRIBUTS
    private soustotal = $(".sousTotal");
    private soustotalHeader = $('.soustotalHeader');
    private tps = $(".tps");
    private total = $(".total");
    private nbrItem = $(".nbrItem");
    private livraisonGratuite = $("#livraisonGratuite");
    private livraison = $('.livraison');
    private selectLivraison = $('#livraison');

    // Constructeur
    constructor() {
        let refThis = this;
        let refarrSelect = Array.apply(null, document.querySelectorAll('.ajaxQte'));
        for (var i = 0; i < refarrSelect.length; i++) {
            refarrSelect[i].addEventListener("change", function (element) {
                refThis.executerAjax(element);
            });
        }
    }


    public retournerResultat(data) {
        let soustotalArticle = $('.soustotalArticle-' + data["isbn"]);

        //cacher / afficher l'icone du camion de livraison gratuite
        if (data["livraisonGratuite"] > 50.00) {
            this.livraisonGratuite.removeClass('visuallyhidden');
        } else {
            this.livraisonGratuite.addClass('visuallyhidden');
        }

        //cacher / afficher le mode de livraison gratuit
        if (data["livraisonGratuite"] > 50.00) {
            if ($("#livraison option[value='10']").length != 1) {
                this.selectLivraison.append("<option class='gratuite' value='10'> gratuite ( 5 jours ouvrables ) </option>");
            }
        } else {
            $("#livraison option[value='10']").remove();
        }

        this.soustotal.html(data["soustotal"]);
        this.soustotalHeader.html(data["soustotalHeader"]);
        soustotalArticle.html(data["soustotalArticle"]);
        this.tps.html(data["tps"]);
        this.total.html(data["total"]);
        this.nbrItem.html(data["nbrItem"]);
        this.livraison.html(data["livraison"]);
    }

    public executerAjax(element) {
        let quantite = parseInt(element.currentTarget.value);
        let isbn = element.currentTarget.id;
        let refThis = this;
        $.ajax({
            url: 'index.php?controleur=panier&action=majQteAjax&isbn=' + isbn + '&nouvelleQuantite=' + quantite,
            type: 'GET',
            dataType: 'json'
        }).done(function (data) {
            refThis.retournerResultat(data);
        }).catch(function (err) {
            console.log(err);
        });

    }

}
