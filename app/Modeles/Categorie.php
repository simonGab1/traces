<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Categorie
{

    private $id;
    private $nom_fr;
    private $nom_en;

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

    public static function trouver($unIdCategorie):Categorie
    {

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM categories WHERE id = :unIdCategorie";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdCategorie', $unIdCategorie, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $categorie = $requetePreparee->fetch();

        return $categorie;

    }

    public static function trouverTout():array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM categories ORDER BY nom_fr";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $tCategorie = $requetePreparee->fetchALL();

        return $tCategorie;
    }

    public static function trouverParLivre($unIdLivre):array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM categories INNER JOIN categories_livres ON categories.id = categories_livres.categorie_id WHERE livre_id = :unIdLivre";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);

        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $categorieLivre = $requetePreparee->fetchALL();

        return $categorieLivre;


    }

    public function getNomFr():string{


        $nom_fr = $this->nom_fr;
        $nom_fr = str_replace(" /", ", ",$this->nom_fr);


        if(strrpos($nom_fr, ",")!=false) {

            return substr_replace($nom_fr, " et", strrpos($nom_fr, ", "), 1);

        } else {

            return $this->nom_fr;

        }

    }

    public function getNomEn():string{

        $nom_en = $this->nom_en;
        $nom_en = str_replace(" /", ", ",$this->nom_en );


        if(strrpos($nom_en, ",")!=false) {

            return substr_replace($nom_en, " et", strrpos($nom_en, ", "), 1);

        } else {

            return $this->nom_fr;

        }

    }



}