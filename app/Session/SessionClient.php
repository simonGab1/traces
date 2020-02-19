<?php


namespace App\Session;


use App\App;

class SessionClient
{

    private $id = null;

    public function __construct()
    {
    }


    public function setId($unId){
        $this->id = $unId;
    }

    public function getId():int{
        return (int) $this->id;
    }

    // Sauvegarder la session client lors d'une connexion réeussie.
    public function sauvegarder(): void
    {
        $maSession = App::getInstance()->getSession();
        $maSession->setItem('client', $this);
        echo "session client existe.";

    }

    // Supprimer la session client lors d'une deconnection/fermeture naviguateur/nouvelles connection
    public function supprimer()
    {
        $monApp = App::getInstance();
        $monApp->getSession()->supprimerItem('client');
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