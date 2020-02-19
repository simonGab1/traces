<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Auteur
{

    private $id;
    private $nom_auteur;
    private $prenom;
    private $url_blogue;

    public function __construct()
    {
        //vide
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public static function trouverParLivre($unIdLivre):Array
    {

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM auteurs INNER JOIN auteurs_livres ON auteurs_livres.auteur_id = auteurs.id WHERE livre_id = :unIdLivre";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $lesAuteurs = $requetePreparee->fetchALL();

        return $lesAuteurs;

    }
    public static function trouverParActualite($unIdActualite) {

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT prenom, nom_auteur 
          FROM auteurs INNER JOIN actualites ON auteurs.id = actualites.id_auteur
          WHERE actualites.id = :unIdActualite";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdActualite', $unIdActualite, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $auteur = $requetePreparee->fetchALL();

        return $auteur;
    }



    public function getNomPrenom():string{

        return $this->nom_auteur .", ". $this->prenom;

    }

    public function getPrenomNom():string{

        return $this->prenom . " " . $this->nom_auteur;

    }

}