import {Validations} from './Validations';
import {MenuMobile} from './MenuMobile';
import {AjaxPanier} from "./AjaxPanier";
import {AjaxPanierLivraison} from "./AjaxPanierLivraison";
import {AjaxRecherche} from "./AjaxRecherche";
import {AjaxRechercheMobile} from "./AjaxRechercheMobile"
import {AjaxRechercheFooter} from "./AjaxRechercheFooter"
import {ImpressionFacture} from "./ImpressionFacture";

$("body").addClass("js");

new AjaxRecherche();

new AjaxRechercheMobile();

new AjaxRechercheFooter();

new MenuMobile();

new AjaxPanier();

new Validations(objMessages);

new AjaxPanierLivraison();

new ImpressionFacture();