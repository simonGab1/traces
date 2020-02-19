<?php
declare(strict_types=1);

namespace App;

use App\Controleurs\ControleurCompte;
use App\Controleurs\ControleurPanier;
use App\Controleurs\ControleurSite;
use App\Controleurs\ControleurLivre;
use App\Controleurs\ControleurLivraison;
use App\Controleurs\ControleurFacturation;
use App\Controleurs\ControleurValidation;
use App\Session\SessionClient;
use App\Session\SessionPanier;
use App\Session\SessionLivraison;
use App\Session\SessionFacturation;
use \PDO;
use eftec\bladeone\BladeOne;


class App
{
    private static $instance = null;
    private $pdo = null;
    private $blade = null;
    private $cookie = null;
    private $session = null;
    private $monControleur = null;

    private function __construct()
    {
    }

    public static function getInstance(): App
    {
        if (App::$instance === null) {
            App::$instance = new App();
        }
        return App::$instance;
    }

    public function demarrer()//:void
    {
        $this->getSession()->demarrer();
        $this->configurerEnvironnement();
        $this->routerLaRequete();
    }


    public function getSession(): Session
    {

        if ($this->session === null) {
            $this->session = new Session();
        }

        return $this->session;
    }

    public function getSessionPanier(): SessionPanier
    {
        $sessionPanier = null;
        if ($this->getSession()->getItem('panier') === null) {
            $sessionPanier = new SessionPanier();
        } else {
            $sessionPanier = $this->getSession()->getItem('panier');
        }
        return $sessionPanier;
    }

    public function getSessionLivraison(): SessionLivraison
    {
        $sessionLivraison = null;
        if ($this->getSession()->getItem('livraison') === null) {
            $sessionLivraison = new SessionLivraison();
        } else {
            $sessionLivraison= $this->getSession()->getItem('livraison');
        }
        return $sessionLivraison;
    }

    public function getSessionFacturation(): SessionFacturation
    {
        $sessionFacturation = null;
        if ($this->getSession()->getItem('facturation') === null) {
            $sessionFacturation = new SessionFacturation();
        } else {
            $sessionFacturation= $this->getSession()->getItem('facturation');
        }
        return $sessionFacturation;
    }

    public function getSessionClient(): SessionClient
    {
        $sessionClient = null;
        if($this->getSession()->getItem('client') === null){
            $sessionClient = new SessionClient();
        }else{
            $sessionClient = $this->getSession()->getItem('client');
        }
        return $sessionClient;
    }

    public function getFilAriane(): FilAriane
    {

        $filAriane = null;

        if ($this->getSession()->getItem('filAriane') === null) {
            $filAriane = new FilAriane();
        } else {
            $filAriane = $this->getSession()->getItem('filAriane');
        }

        return $filAriane;

    }


    public function getCookie(): Cookie
    {

        if ($this->cookie === null) {
            $this->cookie = new Cookie();
        }

        return $this->cookie;

    }

    private function configurerEnvironnement()//:void
    {
        if ($this->getServeur() === 'serveur-local') {
            error_reporting(E_ALL | E_STRICT);
        }
        date_default_timezone_set('America/Montreal');

    }


    public function getPDO(): PDO
    {
        // C'est plus performant en ram de récupérer toujours la même connexion PDO dans toute l'application.
        if ($this->pdo === null) {
            if ($this->getServeur() === 'serveur-local') {
                $maConnexionBD = new ConnexionBD('localhost', 'root', 'root', '19_rpni3_ginto');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
            } else if ($this->getServeur() === 'serveur-production') {

                $maConnexionBD = new ConnexionBD('timunix2.cegep-ste-foy.qc.ca', '19_ginto', 'singerouge', '19_rpni3_ginto');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();

            }
        }
        return $this->pdo;
    }


    public function getBlade(): BladeOne
    {
        if ($this->blade === null) {
            $cheminDossierVues = '../ressources/vues';
            $cheminDossierCache = '../ressources/cache';
            $this->blade = new BladeOne($cheminDossierVues, $cheminDossierCache, BladeOne::MODE_AUTO);
        }
        return $this->blade;
    }


    public function getServeur(): string
    {
        // Vérifier la nature du serveur (local VS production)
        $env = 'null';
        if ((substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ||
            (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168') ||
            (substr($_SERVER['SERVER_ADDR'], 0, 7) == '192.168')) {
            $env = 'serveur-local';
        } else {
            $env = 'serveur-production';
        }
        return $env;
    }


    public function routerLaRequete()//:void
    {
        $controleur = null;
        $action = null;

        // Déterminer le controleur responsable de traiter la requête
        if (isset($_GET['controleur'])) {
            $controleur = $_GET['controleur'];
        } else {
            $controleur = 'site';
        }

        // Déterminer l'action du controleur
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'accueil';
        }

        // Instantier le bon controleur selon la page demandée
        if ($controleur === 'site') {
            $this->monControleur = new ControleurSite();
            switch ($action) {
                case 'accueil':
                    $this->monControleur->accueil();
                    break;
                case 'apropos':
                    $this->monControleur->aPropos();
                    break;
                case 'connexion':
                    $this->monControleur->connexion();
                    break;
                case 'creercompte':
                    $this->monControleur->creerCompte();
                    break;
                case 'rechercheAjax':
                    $this->monControleur->rechercheAjax();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === 'livre') {
            $this->monControleur = new ControleurLivre();
            switch ($action) {
                case 'index':
                    $this->monControleur->index();
                    break;
                case 'fiche':
                    $this->monControleur->fiche();
                    break;
                case 'categorie':
                    $this->monControleur->categorie();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === "panier") {
            $this->monControleur = new ControleurPanier();
            switch ($action) {
                case 'index':
                    $this->monControleur->index();
                    break;
                case 'majLivraison':
                    $this->monControleur->majLivraison();
                    break;
                case 'ajouterItem':
                    $this->monControleur->ajouterItem();
                    break;
                case 'supprimerItem':
                    $this->monControleur->supprimerItem();
                    break;
                case 'majQte':
                    $this->monControleur->majQte();
                    break;
                case 'majQteAjax':
                    $this->monControleur->majQteAjax();
                    break;
                case 'majLivraisonAjax':
                    $this->monControleur->majLivraisonAjax();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }
        else if ($controleur === "compte") {
            $this->monControleur = new ControleurCompte();
            switch ($action) {
                case 'connexion':
                    $this->monControleur->connexion();
                    break;
                case 'deconnexion':
                    $this->monControleur->deconnexion();
                    break;
                case 'validationConnexion':
                    $this->monControleur->validationConnexion();
                    break;
                case 'creercompte':
                    $this->monControleur->creerCompte();
                    break;
                case 'validationInscription':
                    $this->monControleur->insererInscription();
                    break;
                case 'validationAjaxCourriel':
                    $this->monControleur->validationAjaxCourriel();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }else if ($controleur === "livraison") {
            $this->monControleur = new ControleurLivraison();
            switch ($action) {
                case 'livraison':
                    $this->monControleur->livraison();
                    break;
                case 'inserer':
                    $this->monControleur->inserer();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }else if ($controleur === "facturation") {
            $this->monControleur = new ControleurFacturation();
            switch ($action) {
                case 'facturation':
                    $this->monControleur->facturation();
                    break;
                case 'inserer':
                    $this->monControleur->inserer();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }else if ($controleur === "validation") {
            $this->monControleur = new ControleurValidation();
            switch ($action) {
                case 'validation':
                    $this->monControleur->validation();
                    break;
                case 'confirmation':
                    $this->monControleur->confirmation();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }
    else {
            echo 'Erreur 404';
        }
    }


}