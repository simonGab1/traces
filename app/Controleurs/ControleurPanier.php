<?php
declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;
use App\Modeles\Transaction\ModeLivraison;

class ControleurPanier
{
    private $blade = null;
    private $monApp = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->monApp = App::getInstance();
    }

    public function index()
    {
        // Session //
        $tItems = App::getInstance()->getSessionPanier()->getItems();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $tps = App::getInstance()->getSessionPanier()->getMontantTPS();
        $livraison = App::getInstance()->getSessionPanier()->getMontantFraisLivraison();
        $total = App::getInstance()->getSessionPanier()->getMontantTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $modesLivraison = ModeLivraison::trouverTout();
        $sessionPanier = App::getInstance()->getSessionPanier();
        $pageActive = 'index.php?controleur=panier&action=index';
        $idClient = $this->monApp->getSessionClient()->getId();

        $tDonnees = array("items" => $tItems);
        $tDonnees = array_merge($tDonnees, array("pageActive" => $pageActive));
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("tps" => $tps));
        $tDonnees = array_merge($tDonnees, array("livraison" => $livraison));
        $tDonnees = array_merge($tDonnees, array("total" => $total));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("nomPage" => "Panier"));
        $tDonnees = array_merge($tDonnees, array("modesLivraison" => $modesLivraison));
        $tDonnees = array_merge($tDonnees, array("livraisonGratuite" => $sessionPanier->calculerDateLivraisonGratuit()));
        $tDonnees = array_merge($tDonnees, array("sessionPanier" => $sessionPanier));
        $tDonnees = array_merge($tDonnees, array("idClient" => $idClient));


        //retourner une vue
        echo $this->blade->run("panier.index", $tDonnees);

    }

    public function majLivraison()
    {
        $sessionPanier = App::getInstance()->getSessionPanier();
        $formLivraison = '';
        if (isset($_POST['modesLivraison'])) {
            if ($_POST['modesLivraison'] !== "") {
                $formLivraison = ModeLivraison::trouver($_POST['modesLivraison']);
            }
        }
        $pageActive = 'Location: index.php?controleur=panier&action=index';
        if (isset($_POST['pageActive'])) {
            $pageActive = 'Location: ' . $_POST['pageActive'];
        }

        //Ajouter le message de rétroaction
        $sessionPanier->majModeLivraison($formLivraison);
        //sauvegarder la session//
        $sessionPanier->sauvegarder();

        header($pageActive);
        exit;
    }

    public function ajouterItem()
    {

        // Session //
        $sessionPanier = App::getInstance()->getSessionPanier();

        //Récupérer ISBN dans la querystring//
        if (isset($_GET['isbn'])) {
            $numeroIsbn = $_GET['isbn'];
        } else {
            $numeroIsbn = "-1";
        }

        //Récupérer id dans la querystring//
        if (isset($_GET['id'])) {
            $numeroId = $_GET['id'];
        } else {
            $numeroId = "-1";
        }

        //Trouver l'instance livre associé à l'isbn//
        $livres = Livre::trouver($numeroId);


        //Récupérer la Quantité avec la méthode POST//
        if (isset($_POST['quantite'])) {
            $quantite = $_POST['quantite'];
        } else {
            $quantite = -1;
        }

        //Ajouter item au panier//
        $sessionPanier->ajouterItem($livres, (int)$quantite);

        //Ajouter le message de rétroaction
        $sessionPanier->ajoutMessage($livres);


        //sauvegarder la session//
        $sessionPanier->sauvegarder();

        if (isset($_POST['accueil'])) {
            header('Location: index.php?controleur=site&action=accueil');
            exit;
        } else {
            header('Location: index.php?controleur=livre&action=fiche&id=' . $numeroId);
            exit;
        }

    }

    public function majQte()
    {

        // Session //
        App::getInstance()->getSessionPanier();

        if (isset($_GET['isbn'])) {
            $numeroIsbn = $_GET['isbn'];
        } else {
            $numeroIsbn = "-1";
        }

        //Récupérer la Quantité avec la méthode POST//
        if (isset($_POST['nouvelleQuantite'])) {
            $nouvelleQuantite = $_POST['nouvelleQuantite'];
        } else {
            $nouvelleQuantite = -1;
        }

        $pageActive = 'Location: index.php?controleur=panier&action=index';
        if (isset($_POST['pageActive'])) {
            $pageActive = 'Location: ' . $_POST['pageActive'];
        }

        //Maj Quantité papnier//
        App::getInstance()->getSessionPanier()->majItem($numeroIsbn, (int)$nouvelleQuantite);

        //Recupérer la session//
        App::getInstance()->getSessionPanier()->sauvegarder();

        header($pageActive);
        exit;
    }

    public function supprimerItem()
    {

        // Session //
        App::getInstance()->getSessionPanier();

        if (isset($_GET['isbn'])) {
            $numeroIsbn = $_GET['isbn'];
        } else {
            $numeroIsbn = "-1";
        }

        //Maj Quantité papnier//
        App::getInstance()->getSessionPanier()->supprimerItem($numeroIsbn);

        //Recupérer la session//
        App::getInstance()->getSessionPanier()->sauvegarder();

        header('Location: index.php?controleur=panier&action=index');
        exit;

    }

    public function majQteAjax()
    {

        // Session //
        $sessionPanier = App::getInstance()->getSessionPanier();


        if (isset($_GET['isbn'])) {
            $numeroIsbn = $_GET['isbn'];
        } else {
            $numeroIsbn = "-1";
        }

        //Récupérer la Quantité avec la méthode POST//
        if (isset($_GET['nouvelleQuantite'])) {
            $nouvelleQuantite = $_GET['nouvelleQuantite'];
        } else {
            $nouvelleQuantite = -1;
        }

        //Maj Quantité papnier//
        $sessionPanier->majItem($numeroIsbn, (int)$nouvelleQuantite);

        //Recupérer la session//
        $sessionPanier->sauvegarder();

        $tItems = App::getInstance()->getSessionPanier()->getItems();
        $soustotal = $tItems[$numeroIsbn]->getMontantTotal();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $tps = App::getInstance()->getSessionPanier()->getMontantTPS();
        $total = App::getInstance()->getSessionPanier()->getMontantTotal();
        $nbrItem = App::getInstance()->getSessionPanier()->getNombreTotalItems();
        $sousTotalLivraison = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $livraison = App::getInstance()->getSessionPanier()->getMontantFraisLivraison();

        $data = [];
        $data["soustotal"] = "CAD " . number_format($sousTotal, 2, '.', ',') . " $ ";
        $data["soustotalHeader"] = number_format($sousTotal, 2, '.', ',') . " $";

        $data["soustotalArticle"] = number_format($soustotal, 2, '.', ',') . " $ ";
        $data["tps"] = "CAD " . number_format($tps, 2, '.', ',') . " $";
        $data["total"] = "CAD " . number_format($total, 2, '.', ',') . " $";
        $data["nbrItem"] = $nbrItem;
        $data["livraisonGratuite"] = $sousTotalLivraison;
        $data["livraison"] = "CAD " . number_format($livraison, 2, '.', ',') . " $";
        $data["isbn"] = $_GET['isbn'];

        echo json_encode($data);
    }

    public function majLivraisonAjax()
    {
        $sessionPanier = App::getInstance()->getSessionPanier();
        $formLivraison = '';
        if (isset($_GET['modesLivraison'])) {
            if ($_GET['modesLivraison'] !== "") {
                $formLivraison = ModeLivraison::trouver($_GET['modesLivraison']);
            }
        }

        //Ajouter le message de rétroaction
        $sessionPanier->majModeLivraison($formLivraison);
        //sauvegarder la session//
        $sessionPanier->sauvegarder();

        $livraison = App::getInstance()->getSessionPanier()->getMontantFraisLivraison();
        $jourLivraison = $sessionPanier->getModeLivraison()->calculerDateLivraison();
        $jourLivraisonGratuite = $sessionPanier->calculerDateLivraisonGratuit();
        $total = App::getInstance()->getSessionPanier()->getMontantTotal();
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();


        $data = [];
        $data["livraison"] = "CAD " . number_format($livraison, 2, '.', ',') . " $";
        $data["jourLivraison"] = $jourLivraison;
        $data["jourLivraisonGratuite"] = $jourLivraisonGratuite;
        $data["total"] = "CAD " . number_format($total, 2, '.', ',') . " $";
        $data["soustotal"] = $sousTotal;

        echo json_encode($data);


    }


}


