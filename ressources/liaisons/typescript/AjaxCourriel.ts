/**
 * @author Andréa Deshaies <andreadeshaies@gmail.com>
 */


export class AjaxCourriel {

    // ATTRIBUTS
    private courriel = document.querySelector("#courriel");
    private message = document.querySelector("#AjaxCourriel");

    // Constructeur
    constructor() {
    }

    public retournerResultat(data) {
        if(data.message == ""){
        }
        else{
            this.courriel.className = "inputGeneral erreurInput";
            this.message.innerHTML = data.message;
            this.message.className = "messageErreur erreur";
        }
    }

    public executerAjax(element) {
        let courriel = element.currentTarget.value;

        var refThis = this;
        $.ajax({
            url: 'index.php?controleur=compte&action=validationAjaxCourriel&courriel=' + courriel,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json'
        }).done(function (data) {
            refThis.retournerResultat(data);
        }).catch(function (err) {
            console.log("fail");
        });
    }

}