<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Editeur
{

    private $id;
    private $nom_editeur;
    private $url_editeur;

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
        $chaineSQL = "SELECT * FROM editeurs INNER JOIN editeurs_livres ON editeurs.id = editeurs_livres.editeur_id WHERE livre_id = :unIdLivre";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $editeur = $requetePreparee->fetchAll();

        return $editeur;

    }

    public function getNom():string{

        return $this->nom_editeur;

    }

}