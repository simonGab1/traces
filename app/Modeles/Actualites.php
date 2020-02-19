<?php
declare(strict_types=1);



namespace App\Modeles;

use App\App;
use function MongoDB\BSON\toJSON;
use \PDO;

class Actualites
{

    private $id;
    private $date_actualite;
    private $titre_actualite;
    private $texte;
    private $id_auteur;

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


    public static function getActualites() {

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM actualites
                        WHERE actualites.id = 1 OR actualites.id = 13
                      ORDER BY date_actualite
                      LIMIT 2";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        //$requetePreparee->bindParam(':uneQte', $uneQte, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Actualites::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $actualites = $requetePreparee->fetchALL();


        return $actualites;
    }


    public function getAuteurs() {

        return Auteur::trouverParActualite($this->id);

    }

    public function texteSansBalisesCoupe(){
        $length = 800;
        $texte = strip_tags($this->texte);
        if(strlen($texte) > $length) {
            $texte = substr($texte, 0, strpos($texte, ' ', $length));
            $texte = $texte . " [...]";
        }
        return $texte;
    }

    public function dateComplete(){
        $date = \DateTime::createFromFormat("Y-m-d", $this->date_actualite);
        return $this->dateFormatFrancais($date);
    }

    public function dateFormatFrancais($date){
        $strdate = "";
        $tMois = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];

        $jour = $date->format("d");
        $mois = $tMois[(int)$date->format("m")];
        $annee = $date->format("Y");

        $strdate = $jour . " " . $mois . " "  . $annee;
        return $strdate;
    }
}