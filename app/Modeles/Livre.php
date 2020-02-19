<?php
declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Livre
{

    private $id;
    private $titre_livre;
    private $nbre_pages;
    public $prix;
    private $isbn;
    private $parution_id;
    private $annee_publication;
    private $mots_cles;
    private $langue;
    private $sous_titre;
    private $description_livre;
    private $collection_id;
    private $autres_caracteristiques;

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

    public function getParution():Parution {
        return Parution::trouver($this->parution_id);
    }

    public function getAuteurs():array {
        return Auteur::trouverParLivre($this->id);
    }

    public function getEditeur():array{
        return Editeur::trouver($this->id);
    }

    public function getHonneur():array{
        return Honneur::trouver($this->id);
    }

    public function getRecension():array{
        return Recension::trouver($this->id);
    }

    public function getCategorie():array{
        return Categorie::trouverParLivre($this->id);
    }


    public static function compterParCategorie(int $uneCategorie):int
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT count(*) FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id WHERE categorie_id = :uneCategorie";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':uneCategorie', $uneCategorie, PDO::PARAM_INT);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $nbrLivres = $requetePreparee->fetch();

        return intval($nbrLivres[0]);
    }

    public static function compterParNouveautes():int
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT count(*) FROM livres INNER JOIN parutions ON livres.parution_id = parutions.id WHERE parutions.id = 3";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);

        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $nbrLivres = $requetePreparee->fetch();

        return intval($nbrLivres[0]);
    }

    public static function compter():int
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT count(*) FROM livres";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $nbrLivres = $requetePreparee->fetch();

        return intval($nbrLivres[0]);
    }

    public static function trouverParLimiteParNouveaute(int $unIndex, int $uneQte, string $unTri):array
    {

        switch($unTri){
            case'alphaDesc':
                $leTri = ' livres.titre_livre DESC ';
                break;
            case'prixAsc':
                $leTri = ' livres.prix ASC ';
                break;
            case'prixDesc':
                $leTri = ' livres.prix DESC ';
                break;
            default:
                $leTri =' livres.titre_livre ASC ';
        }

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT  livres.id, livres.titre_livre, livres.prix, livres.isbn FROM livres INNER JOIN parutions ON parutions.id = livres.parution_id WHERE parutions.id = 3 ORDER BY "."$leTri"." LIMIT :unIndex, :uneQte";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIndex', $unIndex, PDO::PARAM_INT);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':uneQte', $uneQte, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $livres = $requetePreparee->fetchALL();

        return $livres;
    }



    public static function trouverParLimiteParCategorie(int $unIndex, int $uneQte, int $uneCategorie, string $unTri):array
    {

        switch($unTri){
            case'alphaDesc':
                $leTri = ' livres.titre_livre DESC ';
                break;
            case'prixAsc':
                $leTri = ' livres.prix ASC ';
                break;
            case'prixDesc':
                $leTri = ' livres.prix DESC ';
                break;
            default:
                $leTri =' livres.titre_livre ASC ';
        }

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT livres.id, livres.titre_livre, livres.prix, livres.isbn FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id WHERE categorie_id = :uneCategorie ORDER BY "."$leTri"." LIMIT :unIndex, :uneQte";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIndex', $unIndex, PDO::PARAM_INT);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':uneQte', $uneQte, PDO::PARAM_INT);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':uneCategorie', $uneCategorie, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $livres = $requetePreparee->fetchALL();

        return $livres;
    }

    public static function trouverParLimite(int $unIndex, int $uneQte, string $unTri):array
    {
        switch($unTri){
            case'alphaDesc':
                $leTri = ' livres.titre_livre DESC ';
                break;
            case'prixAsc':
                $leTri = ' livres.prix ASC ';
                break;
            case'prixDesc':
                $leTri = ' livres.prix DESC ';
                break;
            case'nouveautes':
                $leTri = 'livres.annee_publication';
                break;
            default:
                $leTri =' livres.titre_livre ASC ';
        }


        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM livres ORDER BY "."$leTri"." LIMIT :unIndex, :uneQte";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIndex', $unIndex, PDO::PARAM_INT);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':uneQte', $uneQte, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $livres = $requetePreparee->fetchALL();

        return $livres;
    }

    public static function trouverParMotCleParCritere(string $motCle,string $unCritere):array
    {

        switch($unCritere){
            case'auteur':
                $innerJoin = " INNER JOIN auteurs_livres ON livres.id = auteurs_livres.livre_id INNER JOIN auteurs ON auteurs_livres.auteur_id = auteurs.id ";
                $unCritere = " nom_auteur";
                break;
            case'sujet':
                $innerJoin = "";
                $unCritere = " mots_cles";
                break;
            default:
                $innerJoin = '';
                $unCritere ='';
        }

        $where = $unCritere . " LIKE '%".$motCle."%' ";

        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT livres.id, livres.titre_livre, livres.prix, livres.isbn FROM livres ".$innerJoin." WHERE ".$where." LIMIT 5";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $livres = $requetePreparee->fetchALL();

        return $livres;
    }

    public static function trouverTout():array
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT * FROM livres";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer
        $unLivre = $requetePreparee->fetchALL();

        return $unLivre;


    }

    public function getLink(int $unSize):string
    {

        //Conversion
        $strISBN13="L".$this->getEan()."1";


        $nomfichier="liaisons/images/couvertures/".$strISBN13."_w".$unSize.".jpg";

        //Détection du fichier
        if (!file_exists($nomfichier)) {
            $nomfichier="liaisons/images/placeholder_w".$unSize.".jpg";
        }

        return $nomfichier;
    }

    /*
    * @method ISBNToEAN
    * @desc Convertit un ISBN en format EAN
    * @param string - ISBN à convertir
    * @return string - ISBN converti en EAN, ou FALSE si erreur dans le format ou la conversion
    */
    public function getEan()
    {

        $strISBN = $this->isbn;
        $myFirstPart = $mySecondPart = $myEan = $myTotal = "";

        if ($strISBN == "")
            return false;

        $strISBN = str_replace("-", "", $strISBN);

        // ISBN-10
        if (strlen($strISBN) == 10){
            $myEan = "978" . substr($strISBN, 0, 9);

            $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));

            $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));

            $tmp = intval(substr((string)(3 * $myFirstPart + $mySecondPart), -1));

            $myControl = ($tmp == 0) ? 0 : 10 - $tmp;

            return $myEan . $myControl;
        }
        // ISBN-13
        else if (strlen($strISBN) == 13) return $strISBN;
        // Autre
        else return false;
    }

    public static function trouver($unIdLivre)
    {
        $monApp = App::getInstance();
        $pdo = $monApp->getPDO();

        // Définir la chaine SQL
        $chaineSQL = "SELECT *  FROM livres WHERE id = :unIdLivre";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);
        // Définir la méthode de validation des variables associées aux marqueurs nommés de la requête (ici un seul)
        $requetePreparee->bindParam(':unIdLivre', $unIdLivre, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $unLivre = $requetePreparee->fetch();

        return $unLivre;

    }

    public function getDescription():string
    {
        return strip_tags($this->description_livre);
    }

    public function getCaracteristique():string
    {
        return strip_tags($this->autres_caracteristiques);
    }

    public function getTitre():string
    {
        $premierMot = $this->get_string_between($this->titre_livre, "(", ")");

        $resteDuNom = preg_replace('/\([\s\S]+?\)/', '', $this->titre_livre);

        return $premierMot." ".$resteDuNom;
    }

    public function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }


    public function getTitreCoupe(){
        $length = 50;
        $texte = $this->getTitre();
        if(strlen($texte) > $length) {
            $texte = substr($texte, 0, $length);
            $texte = $texte . " [...]";
        }
        return $texte;
    }

}