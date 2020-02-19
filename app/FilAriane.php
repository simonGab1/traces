<?php
declare(strict_types=1);

namespace App;

use App\Modeles\Livre;
use App\Modeles\Categorie;

class FilAriane
{

    private $session = null;

    public function __construct()
    {
        $this->session = App::getInstance()->getSession();
    }

    public static function majFilAriane(): array{
        $fil=array();

        //Si le contrôleur est défini
        if(isset($_GET["controleur"])){

            //Si le contrôleur n'est pas celui du site, nous sommes au deuxième niveau
            if($_GET["controleur"] !== 'site') {
                switch(true){
                    //Si l'action est d'afficher une liste de livres
                    case  $_GET["action"] === 'index' :

                        //Lien de retour vers l'accueil
                        $lien0=array("titre"=>"Accueil","lien"=>"index.php?controleur=site&action=accueil");

                        if(isset($_GET["categorie"])){
                            $categorie = Categorie::trouver((int)$_GET["categorie"]);
                            $lien1=array("titre"=> $categorie->getNomFr());
                        } else {

                            if (isset($_GET["nouveautes"])) {
                                $lien1 = array("titre" => "Nouveautés");
                            } else {
                                $lien1 = array("titre" => "Livres");
                            }
                        }
                        $fil[0] = $lien0;
                        $fil[1] = $lien1;
                        break;

                    //Si l'action d'afficher une fiche de livre
                    case  $_GET["action"] === 'fiche' :

                        //Lien de retour vers l'accueil
                        $lien0=array("titre"=>"Accueil","lien"=>"index.php?controleur=site&action=accueil");

                        //Lien vers la liste des pages se qualifiant (catégorie, nouveauté...)
                        if(isset($_GET["categorie"])){
                            $categorie = Categorie::trouver((int)$_GET["categorie"]);
                            $lien1=array("titre"=> $categorie->getNomFr(),"lien"=>"index.php?controleur=livre&action=index&categorie=".$_GET["categorie"]);
                        } else {

                            if (isset($_GET["nouveautes"])) {
                                $lien1=array("titre"=>"Nouveautés","lien"=>"index.php?controleur=livre&action=index&nouveautes=".$_GET["nouveautes"]);
                            } else {
                                $lien1=array("titre"=>"Livres","lien"=>"index.php?controleur=livre&action=index");
                            }
                        }

                        //Gosser la querystring
                        if (isset($_GET['page'])) {
                            $lien1["lien"]=$lien1["lien"]."&page=" . $_GET['page'];
                        }


                        $fil[0] = $lien0;
                        $fil[1] = $lien1;

                        if(isset($_GET["id"])) {
                            $livre = Livre::trouver($_GET["id"]);
                            $fil[2]=array("titre"=>$livre->getTitreCoupe());
                        }
                        break;
                }
            }
        }
        return $fil;
    }

    // Getter / Setter (magique)

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