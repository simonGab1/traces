<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Province
{

    private $abbr_province;
    private $nom;
    private $lettres_code_postal;
    private $abbr_pays;


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

    public static function trouver($unAbbrProvince): Province
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_province WHERE abbr_province = :unAbbrProvince";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unAbbrProvince', $unAbbrProvince, PDO::PARAM_STR);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Province::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $uneProvince = $requetePreparee->fetch();

        return $uneProvince;

    }

    public static function trouverTout(): array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_province";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Province::class);

        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $Provinces = $requetePreparee->fetchALL();

        return $Provinces;


    }

}