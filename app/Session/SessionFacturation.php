<?php
declare(strict_types=1);

namespace App\Session;


use App\App;


class SessionFacturation
{

    private $items = [];


    public function __construct()
    {
    }

    // Retourner le tableau d'items du panier
    public function getItems(): array
    {
        return $this->items;
    }

    // Sauvegarder le panier en variable session nommée: panier
    public function sauvegarder(Array $tDonnees): void
    {
        $this->items = $tDonnees;
        $maSession = App::getInstance()->getSession();
        $maSession->setItem('facturation', $this);


    }

    // Supprimer le panier en variable session
    public function supprimer(){

        $monApp = App::getInstance();
        $monApp->getSession()->supprimerItem('facturation');

    }

}
