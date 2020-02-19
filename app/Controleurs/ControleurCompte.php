<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Transaction\Client;
use App\Utilitaires;



class ControleurCompte
{

    private $blade = null;
    private $tnewClient = null;
    private $tnewConnexion = null;
    private $session = null;
    private $monApp = null;


    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->monApp = App::getInstance();

    }


    public function connexion()
    {
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $this->tnewConnexion = $this->session->getItem("tnewConnexion");
        $this->session->supprimerItem("tnewConnexion");
        $idClient = $this->monApp->getSessionClient()->getId();

        $tDonnees = array("nomPage" => "Connexion");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, array("tnewConnexion" => $this->tnewConnexion));
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("idClient" => $idClient));
        echo $this->blade->run("connexion", $tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function deconnexion(){
        $sessionClient = App::getInstance()->getSessionClient();
        $sessionClient->supprimer();
        header('Location: index.php?controleur=site&action=accueil');
        exit;
    }

    public function validationConnexion(){
        $sessionClient = App::getInstance()->getSessionClient();
        $courriel = $_POST["courrielconnexion"];
        $client = Client::trouverParCourriel($courriel);

        $tValidation = $this->validerConnexion($client->courriel, $client->mot_de_passe);
        $this->session->setItem("tnewConnexion", $tValidation);

        if (array_search(false, array_column($tValidation, 'blnValide')) !== false) {
            // ------  Si une ou plusieurs entrées sont non valides --------
            $this->connexion();
        } else {
            // ------  Si toutes les entrées sont valides -------------------
            $sessionClient->setId($client->id_client);
            $sessionClient->sauvegarder();

            $entransaction = $this->monApp->getSession()->getItem('connexionTransaction');

            if($entransaction===true){
                $this->monApp->getSession()->supprimerItem('connexionTransaction');
                $header = 'Location: index.php?controleur=livraison&action=livraison';

            } else {
                $header = 'Location: index.php?controleur=site&action=accueil';
            }

            header($header);
            exit;
        }
    }

    public function validationAjaxCourriel(){

        $courriel = null;
        if (isset($_GET['courriel'])) {
            $courriel = $_GET['courriel'];
        } else {
            $courriel = "-1";
        }

        $client = Client::trouverParCourriel($courriel);
        if($client->courriel === null){
            $data = [
                'message' => ""
            ];
        }
        else{
            $data = [
                'message' => "Ce courriel existe deja."
            ];
        }
        echo json_encode($data);
    }

    public function creerCompte()
    {
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $this->session = App::getInstance()->getSession();
        $this->tnewClient = $this->session->getItem("tnewClient");
        $this->session->supprimerItem("tnewClient");

        $tDonnees = array("nomPage" => "créer un compte");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, array("tnewClient" => $this->tnewClient ));
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        echo $this->blade->run("creercompte", $tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function insererInscription(){
        $this->session = App::getInstance()->getSession();
        $sessionClient = App::getInstance()->getSessionClient();

        $tValidation = $this->validerInscription();

        $this->session->setItem("tnewClient", $tValidation);

        if (array_search(false, array_column($tValidation, 'blnValide')) !== false) {
            // ------  Si une ou plusieurs entrées sont non valides --------
            header('Location: index.php?controleur=compte&action=creercompte');
            exit;
        } else {
            // ------  Si toutes les entrées sont valides -------------------

            $this->tnewClient = $this->session->getItem("tnewClient");
            $prenom = $this->tnewClient['prenom']['valeur'];
            $nom = $this->tnewClient['nom']['valeur'];
            $courriel = $this->tnewClient['courriel']['valeur'];
            $telephone = str_replace('-', '', $this->tnewClient['telephone']['valeur']);
            $mdp =  $this->tnewClient['motdepasse']['valeur'];
            Client::ajouterClient($prenom, $nom, $courriel, $telephone, $mdp);

            $client = Client::trouverParCourriel($this->tnewClient['courriel']['valeur']);
            $sessionClient->setId($client->id_client);
            $sessionClient->sauvegarder();

            $entransaction = $this->monApp->getSession()->getItem('connexionTransaction');

            if($entransaction===true){
                $this->monApp->getSession()->supprimerItem('connexionTransaction');
                $header = 'Location: index.php?controleur=livraison&action=livraison';

            } else {
                $header = 'Location: index.php?controleur=site&action=accueil';
            }

            header($header);
            exit;
        }
    }

    public function validerInscription():array{
        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('prenom', '#[a-zA-ZÀ-ÿ -]+#',$tValidation);
        $tValidation = Utilitaires::validerChamp('nom', '#[a-zA-ZÀ-ÿ\' -]+#',$tValidation);
        $tValidation = Utilitaires::validerChamp('courriel', '#^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('telephone', '#([(+]*[0-9]+[()+. -]*)#',$tValidation);
        $tValidation = Utilitaires::validerChamp('motdepasse', '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,10}$#',$tValidation);

        return $tValidation;
    }

    public function validerConnexion($motifCourriel, $motifMdp):array {
        $tValidation = [];

        $tValidation = Utilitaires::validerChamp('courrielconnexion', '#^'. $motifCourriel. '$#',$tValidation);
        $tValidation = Utilitaires::validerChamp('motdepasseconnexion', '#^'. $motifMdp . '$#',$tValidation);

        return $tValidation;
    }

}