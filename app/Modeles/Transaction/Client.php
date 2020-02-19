<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Client
{

    private $id_client;
    private $prenom;
    private $nom;
    private $courriel;
    private $telephone;
    private $mot_de_passe;


    public function __construct()
    {
        //vide
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function getAdresse():Adresse{
        return Adresse::trouver($this->id_client);
    }

    public function getModePaiement():ModePaiement{
        return ModePaiement::trouverParClient($this->id_client);
    }

    public static function trouver($unIdClient):Client
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT *  FROM t_client WHERE id_client = :unIdClient";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdClient', $unIdClient, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Client::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unClient = $requetePreparee->fetch();

        return $unClient;
    }

    public static function trouverParCourriel($unCourriel):Client
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT *  FROM t_client WHERE courriel = :unCourriel";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unCourriel', $unCourriel, PDO::PARAM_STR);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Client::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unClient = $requetePreparee->fetch();

        if(!$unClient){
            $unClient = new Client();
        }

        return $unClient;
    }

    public static function ajouterClient($prenom, $nom, $courriel, $telephone, $mdp){
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "INSERT INTO t_client (prenom,nom,courriel,telephone,mot_de_passe)
                      VALUES (:prenom, :nom, :courriel, :telephone, :mdp)";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $requetePreparee->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requetePreparee->bindParam(':courriel', $courriel, PDO::PARAM_STR);
        $requetePreparee->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $requetePreparee->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        // Exécuter la requête
        $requetePreparee->execute();
    }

}