<?php
declare(strict_types=1);

namespace App\Session;

use App\Modeles\Livre;
use App\App;


class SessionPanier
{

    private $items = [];
    private $message = "";
    private $modesLivraison = '';


    public function __construct()
    {
    }

    // Ajoute un item au panier avec la qantité X
    // Attention: Si l'item existe déjà dans le panier alors mettre à jour la quantité (la quantité maximum est de 10 à valider...)
    public function ajouterItem(Livre $unLivre, int $uneQte): void
    {
        if (!isset($this->items[$unLivre->isbn])) {
            $this->items[$unLivre->isbn] = new SessionItem($unLivre, $uneQte);
        } else {
            $this->setQuantiteItem($unLivre->isbn, $uneQte);
        }
    }

    public function majModeLivraison($modeLivraison): void
    {
        $this->modesLivraison = $modeLivraison;
    }

    public function majItem($isbn, int $uneQte): void
    {
        if ($uneQte != 0){
            $this->majQuantiteItem($isbn, $uneQte);

        }else{
            $this->supprimerItem($isbn);
        }
    }

    // Supprimer un item du panier
    public function supprimerItem(string $isbn): void
    {
        unset($this->items[$isbn]);
    }

    // Retourner le tableau d'items du panier
    public function getItems(): array
    {
        return $this->items;

    }


    public function getModeLivraison()
    {
        return $this->modesLivraison;
    }

    // Mettre à jour la quantité d'un item
    public function setQuantiteItem(string $isbn, int $uneQte): void
    {
        if ($this->items[$isbn]->quantite <= 10) {
            $this->items[$isbn]->quantite = $this->items[$isbn]->quantite + $uneQte;
            if ($this->items[$isbn]->quantite > 10) {
                $this->items[$isbn]->quantite = 10;
            }
        }
    }

    public function majQuantiteItem(string $isbn, int $uneQte): void
    {
            $this->items[$isbn]->quantite = $uneQte;
    }

    // Retourner la quantité d'un item
    public function getQuantiteItem(string $isbn): int
    {
        return $this->items[$isbn]->quantite;
    }


    // Retourner le nombre d'item différents (unique) dans le panier
    public function getNombreTotalItemsDifferents(): int
    {
        return count($this->items);

    }

    // Retourner le nombre de livres total dans le panier (somme de la quantité de chaque item)
    public function getNombreTotalItems(): int
    {
        $nbrTotal = 0;
        foreach ($this->items as $item) {
            $nbrTotal = $nbrTotal + $item->quantite;
        }
        return $nbrTotal;
    }

    // Retourner le montant sousTotal du panier (somme des montantTotals de chaque item)
    public function getMontantSousTotal(): float
    {
        $sousTotal = 0;
        foreach ($this->items as $item) {
            $sousTotal = $sousTotal + $item->getMontantTotal();
        }
        return round($sousTotal, 2);
    }



    // Retourner de montant de la TPS
    // TPS = 5%
    public function getMontantTPS(): float
    {
        return $this->getMontantSousTotal() * 5 / 100;
    }


    // Retourner le montant des frais de livraison
    // Frais de livraison (base=4$ + taux par item=3,50$) Exemple, 1livre=7,50$, 2livres=11$ etc.
    // Il n’y a pas de taxes sur les frais de livraison. Ils s’ajoutent en dernier.
    public function getMontantFraisLivraison(): float
    {
        $nbrLivres = $this->getNombreTotalItems();
        $livraison = 0;

        if ($nbrLivres === 0 || $this->modesLivraison === '') {
            return $livraison;
        } else {
            return $livraison = $this->modesLivraison->base + ($nbrLivres * $this->modesLivraison->par_item);
        }
    }

    // Retourner le montant total de la commande (montant sous-total + TPS + montant livraison)
    public function getMontantTotal(): float
    {
        $livraison = $this->getMontantFraisLivraison();
        $soustotal = $this->getMontantSousTotal();
        $tps = $this->getMontantTPS();

        if ($soustotal == 0 && $tps == 0) {
            $livraison = 0;
            return $soustotal + $tps + $livraison;
        } else {
            return $soustotal + $tps + $livraison;

        }
    }


    // Sauvegarder le panier en variable session nommée: panier
    public function sauvegarder(): void
    {

        $maSession = App::getInstance()->getSession();
        $maSession->setItem('panier', $this);

    }

    // Supprimer le panier en variable session
    public function supprimer(){
        $monApp = App::getInstance();
        $monApp->getSession()->supprimerItem('panier');
    }

    // Gérer message d'ajout au panier
    public function ajoutMessage(Livre $livre){
        $this->message =  $livre->getTitre();
    }

    public function messageSupp(){
        $this->message = "";
    }

    public function getMessage(){
        return $this->message;
    }

    public function calculerDateLivraisonGratuit(){
        $date = new \DateTime();
        $date->add(new \DateInterval('P5D'));
        setlocale(LC_TIME, "fr_CA");
        return strftime("%d %B %Y",$date->getTimestamp());
    }

}
