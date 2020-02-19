<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Transaction\Client;
use App\Modeles\Transaction\Province;
use App\Utilitaires;


class ControleurFacturation
{

    private $blade = null;
    private $monApp = null;

    public function __construct()
    {
        $this->monApp = App::getInstance();
        $this->blade = $this->monApp->getBlade();

    }


    public function facturation(): void
    {


        $sessionFacturation = App::getInstance()->getSessionFacturation()->getItems();
        $sessionFacturationExist=false;

        $adresse = App::getInstance()->getSessionLivraison()->getItems();


        if(count($adresse) < 1){
            $sessionLivraison = false;
        } else {
            $sessionLivraison = true;
        }



        if($sessionLivraison === false){

            // ------  Si une ou plusieurs entrées sont non valides --------
            $header = 'Location: index.php?controleur=livraison&action=livraison';
            header($header);
            exit;

        } else {

            $idClient = App::getInstance()->getSessionClient()->getId();
            $client = Client::trouver($idClient);

            $sessionLivraison = App::getInstance()->getSessionLivraison()->getItems();

            if (App::getInstance()->getSessionFacturation()->getItems() != null) {

                $sessionFacturationExist = true;

                $facturation = $sessionFacturation;

            } else {

                $facturation = $client->getModePaiement();
            }


            $tDonnees = array("nomPage" => "Facturation");
            $tDonnees = array_merge($tDonnees, array("sessionLivraison" => $sessionLivraison));
            $tDonnees = array_merge($tDonnees, array("sessionFactruration" => $sessionFacturation));
            $tDonnees = array_merge($tDonnees, array("sessionFacturationExist" => $sessionFacturationExist));
            $tDonnees = array_merge($tDonnees, array("provinces" => $provinces = Province::trouverTout()));
            $tDonnees = array_merge($tDonnees, array("adresse" => $adresse));
            $tDonnees = array_merge($tDonnees, array("facturation" => $facturation));
            $tDonnees = array_merge($tDonnees, array("adresse_facturation" => $adresse['adresse_facturation']['valeur']));

            //Retourner une vue
            echo $this->blade->run("transaction.facturation", $tDonnees); // /ressource/vues/index.blade.php doit exister...
        }
    }

    public function inserer(): void
    {
        $tValidation = $this->valider();

        // Rediriger au bon endroit selon le bilan global
        $this->monApp->getSessionFacturation()->sauvegarder($tValidation);


        if (array_search(false, array_column($tValidation, 'blnValide')) !== false) {

            // ------  Si une ou plusieurs entrées sont non valides --------
            $header = 'Location: index.php?controleur=facturation&action=facturation';

        } else {

            // ------  Si toutes les entrées sont valides -------------------
            $header ='Location: index.php?controleur=validation&action=validation';

        }

        header($header);
        exit;
    }

    public function valider():array
    {
        $adresse = App::getInstance()->getSessionLivraison()->getItems();


        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('paiement', '#^paypal|credit$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('nomtitulaire', "#^[a-zA-ZÀ-ÿ' -]{2,}$#",$tValidation);
        $tValidation = Utilitaires::validerCarteCredit('numCredit',$tValidation);
        $tValidation = Utilitaires::validerChamp('codeSecurite', '#^[0-9]{3}$#',$tValidation);
        $tValidation = Utilitaires::validerDateExpiration('expiration','annee', 'mois', $tValidation);

        if($adresse['adresse_facturation']['valeur']!=='facturation'){
            $tValidation = Utilitaires::validerChamp('adresse', '#^[a-zA-ZÀ-ÿ0-9 -]{2,}$#',$tValidation);
            $tValidation = Utilitaires::validerChamp('ville', '#^[a-zA-ZÀ-ÿ \-]{2,}$#',$tValidation);
            $tValidation = Utilitaires::validerChamp('province', '#^[A-Z]{2}$#',$tValidation);
            $tValidation = Utilitaires::validerChamp('code_postal', '#^[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]$#',$tValidation);
       }


        return $tValidation;
    }


}

