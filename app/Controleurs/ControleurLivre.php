<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Auteur;
use App\Modeles\Editeur;
use App\Modeles\Livre;
use App\Modeles\Categorie;
use App\Modeles\Collection;


class ControleurLivre
{

    private $blade = null;
    private $monApp = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->monApp = App::getInstance();
    }

    public function index(): void
    {

        $filAriane = App::getInstance()->getFilAriane()::majFilAriane();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $idClient = $this->monApp->getSessionClient()->getId();


        $urlAction = "index.php?controleur=livre&action=";

        $urlLivres = "index.php?controleur=livre&action=index";
        $urlFiche = "index.php?controleur=livre&action=fiche";
        $urlLivresResultats = $urlLivres;
        $urlFicheResultats = $urlFiche;

        $categories = Categorie::trouverTout();

        $categorieEnCours = null;
        //Gosser la querystring
        if (isset($_GET['categorie'])) {
            $idCategorie = $_GET['categorie'];
            $urlLivresResultats = $urlLivres . "&categorie=" . $idCategorie;
            $urlFicheResultats = $urlFiche . "&categorie=" . $idCategorie;
            $nouveautes = 0;
        } else {
            //Gosser la querystring
            if (isset($_GET['nouveautes'])) {
                $nouveautes = "nouveautes";
                $urlLivresResultats = $urlLivres . "&nouveautes=nouveautes";
                $urlFicheResultats = $urlFiche . "&nouveautes=nouveautes";
            } else {
                $nouveautes = 0;
            }
            $idCategorie = 0;
        }


        //Gosser la querystring
        if (isset($_GET['page'])) {
            $noPage = $_GET['page'];
            $urlFicheResultats = $urlFicheResultats . "&page=" . $_GET['page'];
        } else {
            $noPage = 0;
        }

        //Trouver la catégorie en cours
        if ($idCategorie != 0) {
            $categorieEnCours = Categorie::trouver($idCategorie);
        }


        //Limit de resultats
        if (isset($_POST['nbrLivres'])) {
            $nbrLivreMaxParPage = (int)$_POST['nbrLivres'];
        } else {
            $nbrLivreMaxParPage = 8;
        }

        //type de tri
        if (isset($_POST['tri'])) {
            $tri = $_POST['tri'];
        } else {
            $tri = "alphaAsc";
        }


        //Calculer des choses pour la pagination
        if ($idCategorie != 0) {
            $nbrTotalLivres = Livre::compterParCategorie((int)$idCategorie);
        } else {
            if ($nouveautes === "nouveautes") {
                $nbrTotalLivres = Livre::compterParNouveautes();
            } else {
                $nbrTotalLivres = Livre::compter();
            }

        }
        $nombreTotalPages = ceil($nbrTotalLivres / $nbrLivreMaxParPage) - 1;
        $indexCourant = $noPage * $nbrLivreMaxParPage;

        if ($idCategorie != 0) {
            $livres = Livre::trouverParLimiteParCategorie($indexCourant, $nbrLivreMaxParPage, (int)$idCategorie, $tri);
        } else {
            if ($nouveautes === "nouveautes") {
                $livres = Livre::trouverParLimiteParNouveaute($indexCourant, $nbrLivreMaxParPage, $tri);
            } else {
                //Trouver les livres dans la limit demandé
                $livres = Livre::trouverParLimite($indexCourant, $nbrLivreMaxParPage, $tri);
            }
        }
        //Préparer le tableau des valeurs à transmettre


        $tDonnees = array("nomPage" => "Livres");
        $tDonnees = array_merge($tDonnees, array("filAriane" => $filAriane));
        $tDonnees = array_merge($tDonnees, array("categories" => $categories));
        $tDonnees = array_merge($tDonnees, array("nouveautes" => $nouveautes));
        $tDonnees = array_merge($tDonnees, array("categorieEnCours" => $categorieEnCours));
        $tDonnees = array_merge($tDonnees, array("nbrLivreMaxParPage" => $nbrLivreMaxParPage));
        $tDonnees = array_merge($tDonnees, array("tri" => $tri));
        $tDonnees = array_merge($tDonnees, array("numeroPage" => $noPage));
        $tDonnees = array_merge($tDonnees, array("nombreTotalPages" => $nombreTotalPages));

        $tDonnees = array_merge($tDonnees, array("urlAction" => $urlAction));
        $tDonnees = array_merge($tDonnees, array("urlLivres" => $urlLivres));
        $tDonnees = array_merge($tDonnees, array("urlLivresResultats" => $urlLivresResultats));
        $tDonnees = array_merge($tDonnees, array("urlFicheResultats" => $urlFicheResultats));


        $tDonnees = array_merge($tDonnees, array("livres" => $livres));
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("idClient" => $idClient));
        //Retourner une vue
        echo $this->blade->run("livres.index", $tDonnees); // /ressource/vues/index.blade.php doit exister...
    }

    public function fiche(): void
    {

        $filAriane = App::getInstance()->getFilAriane()::majFilAriane();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $idClient = $this->monApp->getSessionClient()->getId();



        //Préparer le tableau des valeurs à transmettre

        if (isset($_GET['id'])) {
            $noId = $_GET['id'];
        } else {
            $noId = 0;
        }

        $categorieEnCours = null;

        if (isset($_GET['categorie'])) {
            $idCategorie = $_GET['categorie'];
        } else {
            $idCategorie = 0;
        }

        //Trouver la catégorie en cours
        if ($idCategorie != 0) {
            $categorieEnCours = Categorie::trouver($idCategorie);
        }

        $monLivre = Livre::trouver($noId);


        $maCollection = Collection::trouverCollection($noId);

        $mesCategories = Categorie::trouverParLivre($noId);

        $categories = null;
        if ($mesCategories != null) {
            foreach ($mesCategories as $categorie) {
                $categories = $categories . $categorie->getNomFr() . ", ";
            }
            $categories = substr_replace($categories, " ", strrpos($categories, ", "), 1);
        }
        $mesAuteurs = Auteur::trouverParLivre($noId);
        $auteurs = null;
        if ($mesAuteurs != null) {
            foreach ($mesAuteurs as $auteur) {
                $auteurs = $auteurs . $auteur->getPrenomNom() . ", ";
            }
            $auteurs = substr_replace($auteurs, " ", strrpos($auteurs, ", "), 1);
        }

        $mesEditeurs = Editeur::trouver($noId);
        $editeurs = null;
        if ($mesEditeurs != null) {
            foreach ($mesEditeurs as $editeur) {
                $editeurs = $editeurs . $editeur->getNom() . ", ";
            }
            $editeurs = substr_replace($editeurs, " ", strrpos($editeurs, ", "), 1);
        }

        $message = App::getInstance()->getSessionPanier()->getMessage();
        App::getInstance()->getSessionPanier()->messageSupp();

        $tDonnees = array("nomPage" => "Fiche");
        $tDonnees = array_merge($tDonnees, array("filAriane" => $filAriane));
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, array("livre" => $monLivre));
        $tDonnees = array_merge($tDonnees, array("collection" => $maCollection));
        $tDonnees = array_merge($tDonnees, array("categories" => $categories));
        $tDonnees = array_merge($tDonnees, array("categorieEnCours" => $categorieEnCours));
        $tDonnees = array_merge($tDonnees, array("afficherAuteurs" => $auteurs));
        $tDonnees = array_merge($tDonnees, array("auteurs" => $mesAuteurs));
        $tDonnees = array_merge($tDonnees, array("editeurs" => $editeurs));
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("message" => $message));
        $tDonnees = array_merge($tDonnees, array("idClient" => $idClient));




        //Retourner une vue
        echo $this->blade->run("livres.fiche", $tDonnees); // /ressource/vues/index.blade.php doit exister...
    }

    public function categorie(): void
    {
        //Préparer le tableau des valeurs à transmettre

        if (isset($_POST['categorie'])) {
            $noCategorie = $_POST['categorie'];
            if ((int)$noCategorie != 0) {
                $header = 'Location: index.php?controleur=livre&action=index&categorie=' . $noCategorie;
            } else {
                $header = 'Location: index.php?controleur=livre&action=index';
            }
            header($header);
            exit;

        } else {

            echo "Erreur 404";
        }


    }

}

