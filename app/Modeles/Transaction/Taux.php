<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Taux
{

    private $id_taux;
    private $date_mise_a_jour;
    private $tps;
    private $tvq;
    private $id_mode_livraison_standard;
    private $id_mode_livraison_prioritaire;


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

    public static function trouver($unIdTaux): Taux
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_taux WHERE id_taux = :unIdTaux";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdTaux', $unIdTaux, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Taux::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unTaux = $requetePreparee->fetch();

        return $unTaux;

    }

    public static function trouverTout(): array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_taux";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $lesTaux = $requetePreparee->fetchALL();

        return $lesTaux;


    }

}