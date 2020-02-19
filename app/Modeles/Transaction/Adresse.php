<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Adresse
{

    private $id_adresse;
    private $prenom;
    private $nom;
    private $adresse;
    private $ville;
    private $code_postal;
    private $est_defaut;
    private $type;
    private $langue;
    private $abbr_province;
    private $id_client;

    public function __construct()
    {
        //vide
    }

    public function inserer(string $prenom,string $nom,string $adresse,string $ville,string $code_postal,int $est_defaut,string $type,string $abbr_province,int $id_client){

        if($est_defaut !== 1){
            $est_defaut = 0;
        }

        if($type!=='facturation'){
            $type = 'livraison';
        }

        $pdo = App::getInstance()->getPDO();
        $sql = "INSERT INTO t_adresse (prenom, nom , adresse, ville, code_postal,est_defaut, type, abbr_province, id_client) VALUES (:prenom, :nom, :adresse, :ville, :code_postal,:est_defaut, :type, :abbr_province, :id_client)";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(':prenom',$prenom,PDO::PARAM_STR,255);
        $requete->bindParam(':nom',$nom,PDO::PARAM_STR,255);
        $requete->bindParam(':adresse',$adresse,PDO::PARAM_STR,255);
        $requete->bindParam(':ville',$ville,PDO::PARAM_STR,100);
        $requete->bindParam(':code_postal',$code_postal,PDO::PARAM_STR,7);
        $requete->bindParam(':est_defaut',$est_defaut,PDO::PARAM_INT);
        $requete->bindParam(':type',$type,PDO::PARAM_STR,15);
        $requete->bindParam(':abbr_province',$abbr_province,PDO::PARAM_STR,3);
        $requete->bindParam(':id_client',$id_client,PDO::PARAM_INT);

        $requete->execute();

        $id = $pdo->lastInsertId();
        $this->id_adresse = $id;

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

    public function getProvince():Province {
        return Province::trouver($this->abbr_province);
    }

    public static function trouver($unIdClient):Adresse
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT *  FROM t_adresse WHERE id_client = :unIdClient";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdClient', $unIdClient, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unAdresse = $requetePreparee->fetch();

        if(!$unAdresse){
            $unAdresse = new Adresse();
        }

        return $unAdresse;
    }

}