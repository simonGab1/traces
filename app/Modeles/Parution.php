<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Parution
{

    private $id;
    private $etat;


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

     public static function trouver($unIdParution):Parution
     {
         $monApp = App::getInstance();
         $pdo = $monApp->getPDO();

         // Définir la chaine SQL
         $chaineSQL = "SELECT *  FROM parutions WHERE id = :unIdParution";
         // Préparer la requête (optimisation)
         $requetePreparee = $pdo->prepare($chaineSQL);
         // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
         $requetePreparee->bindParam(':unIdParution', $unIdParution, PDO::PARAM_INT);
         // Définir le mode de récupération
         $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Parution::class);
         // Exécuter la requête
         $requetePreparee->execute();
         // Récupérer une seule occurrence à la fois
         $uneParution = $requetePreparee->fetch();

         return $uneParution;


     }



}