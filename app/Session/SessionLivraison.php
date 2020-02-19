<?php
declare(strict_types=1);

namespace App\Session;


use App\App;


class SessionLivraison
{

    private $items = [];

    public function __construct()
    {
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
        $maSession->setItem('livraison', $this);
    }

    // Supprimer le panier en variable session
    public function supprimer(){
        $monApp = App::getInstance();
        $monApp->getSession()->supprimerItem('livraison');
    }

}
