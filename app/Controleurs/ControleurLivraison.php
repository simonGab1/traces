<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Transaction\Client;
use App\Modeles\Transaction\Province;
use App\Utilitaires;


class ControleurLivraison
{

    private $blade = null;
    private $monApp = null;

    public function __construct()
    {
        $this->monApp = App::getInstance();
        $this->blade = $this->monApp->getBlade();

    }

    public function livraison(): void
    {

        $idClient = $this->monApp->getSessionClient()->getId();
        $sessionPanier = App::getInstance()->getSessionPanier();
        $tItems = $sessionPanier->getItems();

        if($idClient === 0){

            $this->monApp->getSession()->setItem('connexionTransaction',true);

            $header = 'Location: index.php?controleur=compte&action=connexion';
            header($header);
            exit;
        } elseif(count($tItems) < 1){

            $header = 'Location: index.php?controleur=panier&action=index';
            header($header);
            exit;

        }

        $client = Client::trouver($idClient);

        $adresse = $client->getAdresse();
        $sessionLivraison=null;
        if($this->monApp->getSessionLivraison()->getItems()!=null){

            $sessionLivraison = $this->monApp->getSessionLivraison()->getItems();

        }

        $provinces = Province::trouverTout();

        $tDonnees = array("nomPage" => "Livraison");
        $tDonnees = array_merge($tDonnees, array("adresse" => $adresse));
        $tDonnees = array_merge($tDonnees, array("sessionLivraison" => $sessionLivraison));
        $tDonnees = array_merge($tDonnees, array("provinces" => $provinces));
        //Retourner une vue
        echo $this->blade->run("transaction.livraison", $tDonnees); // /ressource/vues/index.blade.php doit exister...
    }


    public function inserer(): void
    {
        $tValidation = $this->valider();

        // Rediriger au bon endroit selon le bilan global
        $this->monApp->getSessionLivraison()->sauvegarder($tValidation);


        if (array_search(false, array_column($tValidation, 'blnValide')) !== false) {

            // ------  Si une ou plusieurs entrées sont non valides --------
            $header = 'Location: index.php?controleur=livraison&action=livraison';

        } else {

            // ------  Si toutes les entrées sont valides -------------------
            $header ='Location: index.php?controleur=facturation&action=facturation';

        }

        header($header);
        exit;
    }


    public function valider():array
    {

        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('prenom', '#^[a-zA-ZÀ-ÿ -]{2,}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('nom', '#^[a-zA-ZÀ-ÿ -]{2,}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('adresse', '#^[a-zA-ZÀ-ÿ0-9 -]{2,}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('ville', '#^[a-zA-ZÀ-ÿ \-]{2,}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('province', '#^[A-Z]{2}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('code_postal', '#^[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('adresse_defaut', '#^1$#',$tValidation, true);
        $tValidation = Utilitaires::validerChamp('adresse_facturation', '#^facturation$#',$tValidation,true);


        return $tValidation;
    }

}

