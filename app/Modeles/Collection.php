<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Collection
{

    private $id;
    private $nom_collection;
    private $description_collection;

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

    public static function trouverCollection($unIdLivre)
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM collections LEFT JOIN livres ON livres.collection_id = collections.id WHERE livres.id = :unIdLivre";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Collection::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $uneColl = $requetePreparee->fetch();

        return $uneColl;


    }

}