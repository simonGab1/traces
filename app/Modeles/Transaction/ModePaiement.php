<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class ModePaiement
{

    private $id_mode_paiement;
    private $est_paypal;
    private $nom_complet;
    private $no_carte;
    private $type_carte;
    private $date_expiration_carte;
    private $code;
    private $est_defaut;
    private $id_client;


    public function __construct()
    {
        //vide
    }

    public function inserer(int $est_paypal,string $nom_complet,int $no_carte, string $type_carte, string $date_expiration_carte,int $code,int $est_defaut,int $id_client){


        $est_defaut = 0;

        $pdo = App::getInstance()->getPDO();
        $sql = "INSERT INTO t_mode_paiement (est_paypal, nom_complet , no_carte, type_carte, date_expiration_carte, code, est_defaut,id_client) VALUES (:est_paypal, :nom_complet, :no_carte, :type_carte, :date_expiration_carte,:code, :est_defaut, :id_client)";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(':est_paypal',$est_paypal,PDO::PARAM_INT,1);
        $requete->bindParam(':nom_complet',$nom_complet,PDO::PARAM_STR,100);
        $requete->bindParam(':no_carte',$no_carte,PDO::PARAM_INT,20);
        $requete->bindParam(':type_carte',$type_carte,PDO::PARAM_STR,30);
        $requete->bindParam(':date_expiration_carte',$date_expiration_carte,PDO::PARAM_STR,50);
        $requete->bindParam(':code',$code,PDO::PARAM_INT,10);
        $requete->bindParam(':est_defaut',$est_defaut,PDO::PARAM_INT,1);
        $requete->bindParam(':id_client',$id_client,PDO::PARAM_INT);

        $requete->execute();

        $id = $pdo->lastInsertId();
        $this->id_mode_paiement = $id;

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

    public static function trouver($unIdModePaiement): ModePaiement
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_mode_paiement WHERE id_mode_paiement = :unIdModePaiement";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdModePaiement', $unIdModePaiement, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, ModePaiement::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unModePaiement = $requetePreparee->fetch();

        if(!$unModePaiement){
            $unModePaiement = new ModePaiement();
        }

        return $unModePaiement;

    }

    public static function trouverParClient($unIdClient): ModePaiement
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM t_mode_paiement WHERE id_client = :unIdClient ORDER BY id_mode_paiement DESC LIMIT 1";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdClient', $unIdClient, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, ModePaiement::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unModePaiement = $requetePreparee->fetch();

        if(!$unModePaiement){
            $unModePaiement = new ModePaiement();
        }

        return $unModePaiement;

    }

    public function moisExpiration(){
        if(isset($this->date_expiration_carte)){
            $date=date_create($this->date_expiration_carte);
            return date_format($date,"m");
        } else {
            return '';
        }

    }

    public function anneeExpiration(){
        if(isset($this->date_expiration_carte)){
            $date=date_create($this->date_expiration_carte);
            return date_format($date,"Y");
        } else {
            return '';
        }
    }


}