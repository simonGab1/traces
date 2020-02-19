<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Honneur
{

    private $id;
    private $nom_honneur;
    private $description_honneur;

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

    public static function trouver($unIdLivre)
    {

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM honneurs INNER JOIN honneurs_livres ON honneurs.id = honneurs_livres.honneur_id WHERE livre_id = :unIdLivre";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Honneur::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $honneur = $requetePreparee->fetchAll();

        return $honneur;

    }

    public function getNom():string{
        return $this->nom_honneur;
    }

    public function getDescription():string{
        $description = strip_tags($this->description_honneur);
        return preg_replace('/([^?!.]*.).*/', '\\1', $description);
    }

}