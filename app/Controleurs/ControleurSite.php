<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use \DateTime;
use \App\Modeles\Actualites;
use \App\Modeles\Livre;

class ControleurSite
{

    private $blade = null;
    private $monApp = null;


    public function __construct()
    {
        $this->monApp = App::getInstance();
        $this->blade = App::getInstance()->getBlade();
    }

    public function accueil()//: void
    {
        $monApp = App::getInstance();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $idClient = $this->monApp->getSessionClient()->getId();

        if($monApp->getCookie()->get('nbreVisitesCookie')===null){
            $monApp->getCookie()->set('nbreVisitesCookie',0, time()+(60*60*24*30));
            $nbreVisitesCookie = "Vous démarrez une nouvelle session sur le site !";
        } else {
            $monApp->getCookie()->set('nbreVisitesCookie',$monApp->getCookie()->get('nbreVisitesCookie')+1, time()+(60*60*24*30));
            $nbreVisitesCookie =  "Le cookie nbreVisites existe : Vous avez visité la page ". $monApp->getCookie()->get('nbreVisitesCookie') ." fois depuis 30 jours! ";
        }

        if($monApp->getSession()->getItem('nbreVistesSession')===null){
            $monApp->getSession()->setItem('nbreVistesSession',0);
            $nbreVisitesSession = " L’item de session nbreVisites n’existe pas : Vous démarrez une nouvelle session sur le site ! ";
        } else {
            $monApp->getSession()->setItem('nbreVistesSession',$monApp->getSession()->getItem('nbreVistesSession')+1);
            $nbreVisitesSession = "L’item de session nbreVisites existe : Vous avez visité la page ".$monApp->getSession()->getItem('nbreVistesSession')." fois pendant cette session qui expire à la fermeture du navigateur !";
        }

        $urlAction = "index.php?controleur=livre&action=";

        //Actualité
        $actualites = Actualites::getActualites();

        //Nouveautés

        $chiffre = Livre::compterParNouveautes();
        $chiffreHasard = rand(1, $chiffre - 3);
        $livres = Livre::trouverParLimiteParNouveaute($chiffreHasard , 3, "");

        //Message de rétroaction d'ajout au panier
        $message = App::getInstance()->getSessionPanier()->getMessage();
        App::getInstance()->getSessionPanier()->messageSupp();


        $tDonnees = array("nomPage"=>"Accueil");
        $tDonnees = array_merge($tDonnees, array("nbreVisitesCookie" => $nbreVisitesCookie));
        $tDonnees = array_merge($tDonnees, array("nbreVisitesSession" => $nbreVisitesSession));
        $tDonnees = array_merge($tDonnees, array("actualites" => $actualites));
        $tDonnees = array_merge($tDonnees, array("livres" => $livres));
        $tDonnees = array_merge($tDonnees, array("urlAction" => $urlAction));
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("idClient" => $idClient));
        $tDonnees = array_merge($tDonnees, array("message" => $message));
        echo $this->blade->run("accueil",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }





    public function apropos()//:void
    {
        $tDonnees = array("nomPage"=>"À propos");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("apropos",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }


    public static function getDonneeFragmentPiedDePage()
    {
        $date = new DateTime();
        return array("dateDuJour" => $date->format('d M Y'));
    }


    public function rechercheAjax()
    {
        if(isset( $_GET['critere']) && isset($_GET['mot_cle']))

            $critere = $_GET['critere'];
            $motCle = $_GET['mot_cle'];


            if ($critere === 'sujet' || $critere === 'auteur'){

                $livres = Livre::trouverParMotCleParCritere($motCle, $critere);
                $tlivres = [];

                $cpt = 1;
                foreach ($livres as $livre) {
                    $tinfos = [];
                    $tinfos['titre'] = $livre->titre_livre;
                    $tinfos['id'] = $livre->id;

                    $tlivres = array_merge($tlivres, array($cpt => $tinfos));
                    $cpt = $cpt + 1;
                }
                echo json_encode($tlivres);

             } else{
                 echo  json_encode("");
             }
    }
}

