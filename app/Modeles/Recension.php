<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Recension
{

    private $id;
    private $date_recension;
    private $titre_recension;
    private $nom_media;
    private $nom_journaliste;
    private $description_recension;
    private $livre_id;

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
        $chaineSQL = "SELECT * FROM recensions INNER JOIN livres ON livres.id = recensions.livre_id WHERE livre_id = :unIdLivre";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Recension::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $recension = $requetePreparee->fetchAll();

        return $recension;

    }

    public function getDescription():string{
        return strip_tags($this->description_recension);
    }

    public function getDate():string{
        $date = date_create($this->date_recension);
        $dateFormat = date_format($date,'d/m/Y');
        return $dateFormat;
    }

}