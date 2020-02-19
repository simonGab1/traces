/**
 * @author Andréa Deshaies <andreadeshaies@gmail.com>
 * @author Simon-Gabriel Côté-Poulin <simon_gab@outlook.com>

 */
import {AjaxCourriel} from "./AjaxCourriel";


export class Validations {

    // ATTRIBUTS
    private objMessages: any;
    private ajaxCourriel: AjaxCourriel = null;


    //Éléments de formulaire à valider
    //Inscription
    private refNom: JQuery<HTMLElement> = $('#nom');
    private refPrenom: JQuery<HTMLElement> = $('#prenom');
    private refCourriel: JQuery<HTMLElement> = $('#courriel');
    private refTelephone: JQuery<HTMLElement> = $('#telephone');
    private refMotdepasse: JQuery<HTMLElement> = $('#motdepasse');
    //Facturation
    private refNomTitulaire: JQuery<HTMLElement> = $('#nomtitulaire');
    private refNumCredit: JQuery<HTMLElement> = $('#numCredit');
    private refCodeSecurite: JQuery<HTMLElement> = $('#codeSecurite');
    private refExpirationAnnee: JQuery<HTMLElement> = $('#expirationAnnee');
    private refExpirationMois: JQuery<HTMLElement> = $('#expirationMois');
    private refAdresse: JQuery<HTMLElement> = $('#adresse');
    private refVille: JQuery<HTMLElement> = $('#ville');
    private refCodePostal: JQuery<HTMLElement> = $('#code_postal');
    private refProvince: JQuery<HTMLElement> = $('#province');


    // Constructeur
    constructor(objetJSON: any) {

        if($('form').length>0){
            document.querySelector('form').noValidate = true;
        }

        this.objMessages = objetJSON;
        this.ajaxCourriel = new AjaxCourriel();
        this.initialiser();
    }

    private initialiser() {
        this.refNom.on('blur', this.validerChamp.bind(this));
        this.refPrenom.on('blur', this.validerChamp.bind(this));
        this.refCourriel.on('blur', this.validerCourriel.bind(this));
        this.refTelephone.on('blur', this.validerChamp.bind(this));
        this.refMotdepasse.on('blur', this.validerChamp.bind(this));
        this.refNomTitulaire.on('blur', this.validerChamp.bind(this));
        this.refNumCredit.on('blur', this.validerCredit.bind(this));
        this.refCodeSecurite.on('blur', this.validerChamp.bind(this));
        this.refExpirationAnnee.on('change', this.validerExpirationDate.bind(this));
        this.refExpirationMois.on('change', this.validerExpirationDate.bind(this));
        this.refAdresse.on('blur', this.validerChamp.bind(this));
        this.refVille.on('blur', this.validerChamp.bind(this));
        this.refCodePostal.on('blur', this.validerChamp.bind(this));
        this.refProvince.on('change', this.validerProvince.bind(this));


    }


    private validerCourriel(evenement) {
        var valide = this.validerChamp(evenement);

        if (valide) {
            this.ajaxCourriel.executerAjax(evenement);
        }
    }

    private validerChamp(evenement) {
        const lePattern = evenement.currentTarget.pattern;
        const laValeur = evenement.currentTarget.value;
        const nomChamp = evenement.currentTarget.id;
        let target = $(evenement.target);

        $(evenement.target).removeClass(" erreurInput");
        $(evenement.target).removeClass(" success");


        let messageErreur = target.parent("div").children(".messageErreur");


        if (this.verifierSiVide(laValeur)) {
            messageErreur.text(this.objMessages[nomChamp]['vide']);
            messageErreur.addClass("erreur messageErreur");

            $(evenement.target).addClass(" erreurInput");
            return false;
        } else {
            if (this.validerPattern(laValeur, lePattern) == false) {

                messageErreur.text(this.objMessages[nomChamp]['pattern']);
                messageErreur.addClass("erreur messageErreur ");

                $(evenement.target).addClass("erreurInput");
                return false;
            } else {

                messageErreur.text("");
                messageErreur.removeClass("erreur");
                $(evenement.target).addClass("success")

                return true;
            }
        }
    }

    private validerExpirationDate(evenement) {
        let target = $(evenement.target);
        let refAnnee = this.refExpirationAnnee;
        let refMois = this.refExpirationMois;
        let mois = this.refExpirationMois.val();
        let annee = this.refExpirationAnnee.val();
        let jour = "01";
        let messageErreur = target.parent("div").parent("div").parent('div').children(".messageErreur");
        let dateAValider = new Date([annee, mois, jour].join('-'));
        let dateAujourdhui = new Date();

        if (annee != '' && mois != '') {
            if (dateAValider < dateAujourdhui) {

                messageErreur.text(this.objMessages['expiration']['expire']);
                messageErreur.addClass("erreur messageErreur");
                refAnnee.removeClass("inputGeneral menuDeroulant success");
                refMois.removeClass("inputGeneral menuDeroulant success");
                refAnnee.addClass("inputGeneral menuDeroulant erreurInput");
                refMois.addClass("inputGeneral menuDeroulant erreurInput");
            } else {
                messageErreur.text("");
                messageErreur.removeClass("erreur");
                refAnnee.removeClass("inputGeneral menuDeroulant erreurInput");
                refMois.removeClass("inputGeneral menuDeroulant erreurInput");
                refAnnee.addClass("inputGeneral menuDeroulant success");
                refMois.addClass("inputGeneral menuDeroulant success");
            }
        } else {
            if (annee == '' && mois == '') {

                messageErreur.text(this.objMessages['expiration']['vide']);
                messageErreur.addClass("erreur messageErreur");
                refAnnee.removeClass("inputGeneral menuDeroulant success");
                refMois.removeClass("inputGeneral menuDeroulant success");
                refAnnee.addClass("inputGeneral menuDeroulant erreurInput");
                refMois.addClass("inputGeneral menuDeroulant erreurInput");
            } else if (annee != '' && mois == '') {

                messageErreur.text(this.objMessages['expiration']['moisVide']);
                messageErreur.addClass("erreur messageErreur");
                refAnnee.removeClass("inputGeneral menuDeroulant success");
                refMois.removeClass("inputGeneral menuDeroulant success");
                refAnnee.addClass("inputGeneral menuDeroulant erreurInput");
                refMois.addClass("inputGeneral menuDeroulant erreurInput");
            } else if (annee == '' && mois != '') {
                messageErreur.text(this.objMessages['expiration']['anneeVide']);
                messageErreur.addClass("erreur messageErreur");
                refAnnee.removeClass("inputGeneral menuDeroulant success");
                refMois.removeClass("inputGeneral menuDeroulant success");
                refAnnee.addClass("inputGeneral menuDeroulant erreurInput");
                refMois.addClass("inputGeneral menuDeroulant erreurInput");
            }
        }
    }


    private validerProvince(evenement) {
        let target = $(evenement.target);
        const laValeur = evenement.currentTarget.value;

        let messageErreur = target.parent("div").children(".messageErreur");

        if (this.verifierSiVide(laValeur)) {
            messageErreur.text(this.objMessages['province']['vide']);
            messageErreur.addClass("erreur messageErreur");
            evenement.currentTarget.className = "inputGeneral menuDeroulant erreurInput";

        } else {

            messageErreur.text("");
            messageErreur.removeClass("erreur");

            evenement.currentTarget.className = "inputGeneral menuDeroulant success";
            return true;
        }
    }

    private validerCredit(evenement) {
        let target = $(evenement.target);
        const laValeur = evenement.currentTarget.value;

        let motifAmex = "^[3][0-9]{2}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
        let motifMasterCard = "^[5][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";
        let motifVisa = "^[4][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$";

        let messageErreur = target.parent("div").children(".messageErreur");

        if (this.verifierSiVide(laValeur)) {
            messageErreur.text(this.objMessages['numCredit']['vide']);
            messageErreur.addClass("erreur messageErreur");
            evenement.currentTarget.className = "inputGeneral erreurInput";

        } else {
            if (this.validerPattern(laValeur, motifAmex) == true) {
                messageErreur.text("");
                messageErreur.removeClass("erreur");

                evenement.currentTarget.className = "inputGeneral success";
                return true;

            } else if (this.validerPattern(laValeur, motifMasterCard) == true) {
                messageErreur.text("");
                messageErreur.removeClass("erreur");

                evenement.currentTarget.className = "inputGeneral success";
                return true;

            } else if (this.validerPattern(laValeur, motifVisa) == true) {
                messageErreur.text("");
                messageErreur.removeClass("erreur");

                evenement.currentTarget.className = "inputGeneral success";
                return true;

            } else {
                messageErreur.text(this.objMessages['numCredit']['pattern']);
                messageErreur.addClass("erreur messageErreur");
                evenement.currentTarget.className = "inputGeneral erreurInput";
                return false;
            }

        }
    }


// Méthodes utilitaires

    public verifierSiVide(element: string): boolean {
        if (element == "") {
            return true;
        } else {
            return false;
        }
    }

    public validerPattern(element: string, motif: string): boolean {
        const regexp = new RegExp(motif);
        return regexp.test(element);
    }

}