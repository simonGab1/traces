<?php
declare(strict_types=1);

namespace App\Session;

use App\Modeles\Livre;

class SessionItem
{
    private $livre = null;
    private $quantite = 0;

    public function __construct(Livre $unLivre, int $uneQte)
    {
        $this->livre = $unLivre;
        $this->quantite = $uneQte;
    }


    // Retourne le montant total d'un item (prix x quantité)
    public function getMontantTotal()
    {
       return $this->livre->prix * $this->quantite;
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