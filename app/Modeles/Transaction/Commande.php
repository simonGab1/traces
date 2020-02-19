<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class Commande
{

    private $id_commande;
    private $etat;
    private $date;
    private $telephone;
    private $courriel;
    private $id_client;
    private $id_adresse_livraison;
    private $id_adresse_facturation;
    private $id_mode_paiement;
    private $id_mode_livraison;
    private $id_taux;


    public function __construct()
    {
        //vide
    }

    public function inserer(string $etat,string $date ,int $telephone,string $courriel,int $id_client,int $id_adresse_livraison,int $id_adresse_facturation,int $id_mode_paiement,int $id_mode_livraison,int $id_taux){


        $pdo = App::getInstance()->getPDO();
        $sql = "INSERT INTO t_commande (etat, date , telephone, courriel, id_client, id_adresse_livraison, id_adresse_facturation, id_mode_paiement, id_mode_livraison, id_taux) VALUES (:etat, :date, :telephone, :courriel, :id_client, :id_adresse_livraison, :id_adresse_facturation, :id_mode_paiement, :id_mode_livraison, :id_taux)";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(':etat',$etat,PDO::PARAM_STR,20);
        $requete->bindParam(':date',$date,PDO::PARAM_STR,50);
        $requete->bindParam(':telephone',$telephone,PDO::PARAM_INT,20);
        $requete->bindParam(':courriel',$courriel,PDO::PARAM_STR,255);
        $requete->bindParam(':id_client',$id_client,PDO::PARAM_INT,10);
        $requete->bindParam(':id_adresse_livraison',$id_adresse_livraison,PDO::PARAM_INT,10);
        $requete->bindParam(':id_adresse_facturation',$id_adresse_facturation,PDO::PARAM_INT,10);
        $requete->bindParam(':id_mode_paiement',$id_mode_paiement,PDO::PARAM_INT,10);
        $requete->bindParam(':id_mode_livraison',$id_mode_livraison,PDO::PARAM_INT,3);
        $requete->bindParam(':id_taux',$id_taux,PDO::PARAM_INT,1);

        $requete->execute();

        $id = $pdo->lastInsertId();
        $this->id_commande = $id;

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



}