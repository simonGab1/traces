<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Transaction\Adresse;
use App\Modeles\Transaction\Client;
use App\Courriels\CourrielConfirmation;
use App\Modeles\Transaction\Commande;
use App\Modeles\Transaction\LigneCommande;
use App\Modeles\Transaction\ModeLivraison;
use App\Modeles\Transaction\ModePaiement;




class ControleurValidation
{

    private $blade = null;

    private $sessionClient = null;
    private $oldSessionPanier = null;
    private $oldSessionLivraison = null;
    private $oldSessionFacturation = null;
    private $modePaiement = null;
    private $idCommande = null;

    private $nbrTotalItems = null;
    private $montantSousTotal = null;
    private $montantTPS = null;
    private $montantFraisLivraison = null;
    private $montantTotal = null;


    private static $tDonnees = null;


    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function validation()
    {


        $idClient = App::getInstance()->getSessionClient()->getId();

        $sessionPanier = App::getInstance()->getSessionPanier();
        $tItems = $sessionPanier->getItems();

        $sessionLivraison = App::getInstance()->getSessionLivraison()->getItems();
        $sessionFacturation = App::getInstance()->getSessionFacturation()->getItems();


        if(count($tItems) < 1){

            $header = 'Location: index.php?controleur=panier&action=index';
            header($header);
            exit;

        } elseif (count($sessionLivraison) < 1){

            $header = 'Location: index.php?controleur=livraison&action=livraison';
            header($header);
            exit;

        } elseif (count($sessionFacturation) < 1){

            $header = 'Location: index.php?controleur=facturation&action=facturation';
            header($header);
            exit;

        }



        $client = Client::trouver($idClient);



        $pageActive = 'index.php?controleur=validation&action=validation';


        $tDonnees = array("nomPage" => "Validation");

        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("items" => $tItems));
        $tDonnees = array_merge($tDonnees, array("modesLivraison" => ModeLivraison::trouverTout()));
        $tDonnees = array_merge($tDonnees, array("sessionPanier" => $sessionPanier));
        $tDonnees = array_merge($tDonnees, array("sessionLivraison" => $sessionLivraison));
        $tDonnees = array_merge($tDonnees, array("sessionFacturation" => $sessionFacturation));
        $tDonnees = array_merge($tDonnees, array("pageActive" => $pageActive));
        $tDonnees = array_merge($tDonnees, array("client" => $client));

        //Retourner une vue
        echo $this->blade->run("transaction.validation", $tDonnees); // /ressource/vues/index.blade.php doit exister...
    }



    public function confirmation(){

        $idClient = App::getInstance()->getSessionClient()->getId();
        $client = Client::trouver($idClient);

        $sessionPanier = App::getInstance()->getSessionPanier();
        $tItems = $sessionPanier->getItems();

        if(!count($tItems)<1){
            $this->passerCommande();
        }

        if(ControleurValidation::$tDonnees===null) {

            $tDonnees = array("nomPage" => "Confirmation");

            $tDonnees = array_merge($tDonnees, array("sessionPanier" => $this->oldSessionPanier));
            $tDonnees = array_merge($tDonnees, array("sessionLivraison" => $this->oldSessionLivraison));
            $tDonnees = array_merge($tDonnees, array("sessionFacturation" => $this->oldSessionFacturation));

            $tDonnees = array_merge($tDonnees, array("nbrTotalItems" => $this->nbrTotalItems));
            $tDonnees = array_merge($tDonnees, array("montantSousTotal" => $this->montantSousTotal));
            $tDonnees = array_merge($tDonnees, array("montantTPS" => $this->montantTPS));
            $tDonnees = array_merge($tDonnees, array("montantFraisLivraison" => $this->montantFraisLivraison));
            $tDonnees = array_merge($tDonnees, array("montantTotal" => $this->montantTotal));


            $tDonnees = array_merge($tDonnees, array("client" => $client));
            $tDonnees = array_merge($tDonnees, array("idCommande" => $this->idCommande));
            $tDonnees = array_merge($tDonnees, array("modePaiement" => $this->modePaiement));

                $sessionPanier = $this->oldSessionPanier;
                $sessionLivraison = $this->oldSessionLivraison;
                $sessionFacturation = $this->oldSessionFacturation;

                $nbrTotalItems = $this->nbrTotalItems;
                $montantSousTotal = $this->montantSousTotal;
                $montantTPS = $this->montantTPS;
                $montantFraisLivraison = $this->montantFraisLivraison;
                $montantTotal = $this->montantTotal;

                ControleurValidation::$tDonnees = $tDonnees;
            if($this->idCommande) {
                new CourrielConfirmation($client->courriel, $client, $sessionPanier, $sessionLivraison, $sessionFacturation, $nbrTotalItems, $montantSousTotal, $montantTPS, $montantFraisLivraison, $montantTotal);
            }
        }

       echo $this->blade->run("transaction.confirmation", ControleurValidation::$tDonnees); // /ressource/vues/index.blade.php doit exister...

    }



   public function passerCommande(){


       $idClient = App::getInstance()->getSessionClient()->getId();
       $client = Client::trouver($idClient);

       //Inserer l'adresse de livraison dans la bd
       $sessionLivraison = App::getInstance()->getSessionLivraison()->getItems();

       $prenom = $sessionLivraison['prenom']['valeur'];
       $nom = $sessionLivraison['nom']['valeur'];
       $adresse = $sessionLivraison['adresse']['valeur'];
       $ville =$sessionLivraison['ville']['valeur'];
       $code_postal =$sessionLivraison['code_postal']['valeur'];
       $adresse_defaut = (int) $sessionLivraison['adresse_defaut']['valeur'];
       $livraison = 'livraison';
       $province = $sessionLivraison['province']['valeur'];

       $adresseLivraison = new Adresse();
       $adresseLivraison->inserer($prenom, $nom, $adresse, $ville, $code_postal, $adresse_defaut, $livraison, $province,$idClient);

       //Inserer le mode de paiement dans la bd
       $sessionFacturation = App::getInstance()->getSessionFacturation()->getItems();


       $est_paypal = 1;
       $nomtitulaire = $sessionFacturation['nomtitulaire']['valeur'];
       $numCredit = (int) $sessionFacturation['numCredit']['valeur'];
       $typeCarte = $sessionFacturation['numCredit']['typeCarte'];
       $date = $sessionFacturation['expiration']['annee'] . "-".$sessionFacturation['expiration']['mois']."-01";
       $codeSecurite=(int)$sessionFacturation['codeSecurite']['valeur'];
       $est_defaut= 0;
       $facturation = 'facturation';

       $modePaiement = new ModePaiement();
       $modePaiement->inserer($est_paypal, $nomtitulaire , $numCredit,$typeCarte, $date, $codeSecurite, $est_defaut, $idClient);


       //Inserer l'adresse de Facturation dans la bd
      if($sessionLivraison['adresse_facturation']['valeur'] === 'facturation'){
          $adresseFacturation = new Adresse();
          $adresseFacturation->inserer($prenom, $nom, $adresse, $ville, $code_postal, $est_defaut, $facturation, $province, $idClient);
      } else {

          $prenom = $client->prenom;
          $nom = $client->nom;
          $adresse = $sessionFacturation['adresse']['valeur'];
          $ville = $sessionFacturation['ville']['valeur'];
          $code_postal = $sessionFacturation['code_postal']['valeur'];
          $est_defaut= 0;
          $facturation = 'facturation';
          $province =$sessionFacturation['province']['valeur'];

          $adresseFacturation = new Adresse();
          $adresseFacturation->inserer($prenom, $nom, $adresse, $ville, $code_postal, $est_defaut, $facturation, $province,$idClient);
      }

      //Inserer une commande dans la BD

       $etat = 'Nouvelle';
       $date  = date("Y-m-d, G:i:s");
       $telephone = $client->telephone;
       $courriel = $client->courriel;
       $id_client = $idClient;
       $id_adresse_livraison = $adresseLivraison->id_adresse;
       $id_adresse_facturation = $adresseFacturation->id_adresse;
       $id_mode_paiement = $modePaiement->id_mode_paiement;
       $id_mode_livraison = 7;//$idModeLivraison;
       $id_taux = 4;

       $commande = new Commande();
         $commande->inserer($etat, $date ,(int) $telephone, $courriel, $id_client, (int)$id_adresse_livraison, (int)$id_adresse_facturation, (int)$id_mode_paiement, $id_mode_livraison, $id_taux);

       //Inserer le contenu du panier dans la BD

       $items = App::getInstance()->getSessionPanier()->getItems();

       foreach ($items as $item){

           $isbn = $item->livre->isbn;
           $prix = $item->livre->prix;
           $quantite  = $item->quantite;
           $id_commande = $commande->id_commande;

          $ligneCommande = new LigneCommande();
          $ligneCommande->inserer($isbn,  $prix, $quantite,(int) $id_commande);

       }



       //Stocker les Sessions dans des Attributs de Classe avant de les supprimer
       $this->sessionClient = App::getInstance()->getSessionClient();
       $this->oldSessionPanier = App::getInstance()->getSessionPanier()->getItems();
       $this->oldSessionLivraison = App::getInstance()->getSessionLivraison()->getItems();
       $this->oldSessionFacturation = App::getInstance()->getSessionFacturation()->getItems();
       $this->nbrTotalItems = App::getInstance()->getSessionPanier()->getNombreTotalItems();
       $this->montantSousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
       $this->montantTPS = App::getInstance()->getSessionPanier()->getMontantTPS();
       $this->montantFraisLivraison = App::getInstance()->getSessionPanier()->getMontantFraisLivraison();
       $this->montantTotal = App::getInstance()->getSessionPanier()->getMontantTotal();
       $this->idCommande = $id_commande;
       $this->modePaiement = $modePaiement;



       App::getInstance()->getSessionPanier()->supprimer();
       App::getInstance()->getSessionLivraison()->supprimer();
       App::getInstance()->getSessionFacturation()->supprimer();



    }

}

