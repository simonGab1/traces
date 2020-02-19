<?php
declare(strict_types=1);


namespace App\Modeles\Transaction;

use App\App;
use \PDO;

class LigneCommande
{

    private $id_ligne_commande;
    private $isbn;
    private $prix;
    private $quantite;
    private $id_commande;



    public function __construct()
    {
        //vide
    }

    public function inserer(string $isbn,$prix,int $quantite,int $id_commande){


        $pdo = App::getInstance()->getPDO();
        $sql = "INSERT INTO t_ligne_commande (isbn,prix,quantite,id_commande) VALUES (:isbn,:prix,:quantite,:id_commande)";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(':isbn',$isbn,PDO::PARAM_STR,20);
        $requete->bindParam(':prix',$prix,PDO::PARAM_STR,50);
        $requete->bindParam(':quantite',$quantite,PDO::PARAM_INT,3);
        $requete->bindParam(':id_commande',$id_commande,PDO::PARAM_INT,10);

        $requete->execute();

        $id = $pdo->lastInsertId();
        $this->id_ligne_commande = $id;

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