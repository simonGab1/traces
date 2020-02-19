<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class ModeLivraison
{

    private $id_mode_livraison;
    private $date_mise_a_jour;
    private $mode_livraison;
    private $base;
    private $par_item;
    private $delai;
    private $delai_max_jrs;


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

    public static function trouver($unIdModeLivraison): ModeLivraison
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_mode_livraison WHERE id_mode_livraison = :unIdModeLivraison";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdModeLivraison', $unIdModeLivraison, PDO::PARAM_INT);
       // Définir le mode de récupération
       $requetePreparee->setFetchMode(PDO::FETCH_CLASS, ModeLivraison::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unModeLivraison = $requetePreparee->fetch();

        return $unModeLivraison;

    }

    public static function trouverTout():array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_mode_livraison WHERE date_mise_a_jour = '2016-01-01'";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, ModeLivraison::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $ModesLivraison = $requetePreparee->fetchALL();

        return $ModesLivraison;


    }

    public function calculerDateLivraison(){
        $date = new \DateTime();
        $date->add(new \DateInterval('P'.$this->delai_max_jrs.'D'));
        setlocale(LC_TIME, "fr_CA");
        return strftime("%d %B %Y",$date->getTimestamp());
    }

}