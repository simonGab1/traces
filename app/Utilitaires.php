<?php
declare(strict_types=1);

namespace App;

use \DateTime;

class Utilitaires
{

    private $session = null;


    public function __construct()
    {
        $this->session = App::getInstance()->getSession();
    }

    public static function validerChamp(string $nomChamp, string $motif, array $tableauValidation, bool $accepterValeurVideOuInexistante = null):array
    {

        $contenuBruteFichierJson = file_get_contents("../ressources/lang/fr_CA.UTF-8/messagesValidation.json");
        $tMessagesJson = json_decode($contenuBruteFichierJson, true); // Convertir en tableau associatif

        $valeurPost = '';
        $valide = false;
        $message = '';

        if(isset($_POST[$nomChamp])){

            $valeurPost = trim($_POST[$nomChamp]);

            if($valeurPost == '' && !$accepterValeurVideOuInexistante){

                $message = $tMessagesJson[$nomChamp]['vide'];

            } else {

                $trouve = preg_match(($motif),$valeurPost);

                if(!$trouve){
                    $message = $tMessagesJson[$nomChamp]['pattern'];
                } else {
                    $valide = true;
                }

            }

        } else {

            if($accepterValeurVideOuInexistante){
                $valide = true;
            } else {
                $message = $tMessagesJson[$nomChamp]['vide'];
            }
        }

        $tableauValidation[$nomChamp] = ['valeur' => $valeurPost, 'blnValide' => (bool)$valide, 'messageErreur' => $message ];
        return $tableauValidation;


    }


    public static function validerDateExpiration(string $nomDate,string $annee, string $mois, array $tableauValidation){

        $contenuBruteFichierJson = file_get_contents("../ressources/lang/fr_CA.UTF-8/messagesValidation.json");
        $tMessagesJson = json_decode($contenuBruteFichierJson, true);

        $message = '';
        $annee = trim($_POST[$annee]);
        $mois = trim($_POST[$mois]);
        
        if($annee !== '' && $mois !==''){
            
            if(checkdate(intval($mois),01,intval($annee))){
    
                $dateAValider = new DateTime($annee.'-'.$mois.'-01');
                $aujourdhui = new DateTime();
    
                if($aujourdhui<$dateAValider){
    
                    $valide = true;
                    $message = '';
                } else {
                    $valide = false;
                    $message = $tMessagesJson[$nomDate]['expire'];
                }
    
            } else {
    
                $valide = false;
                $message = $tMessagesJson[$nomDate]['pattern'];
            }
        } else {
            
            $valide = false;

            if($annee === '' && $mois ===''){
                $message = $tMessagesJson[$nomDate]['vide'];
            }elseif($mois === '' && $annee != '') {
                $message =  $tMessagesJson[$nomDate]['moisVide'];
            } else {
                $message = $tMessagesJson[$nomDate]['anneeVide'];
            }

        }

        $tableauValidation[$nomDate] = ['annee' => $annee, 'mois' => $mois, 'blnValide' => $valide, 'messageErreur'=> $message];
        return $tableauValidation;

    }

    public static function validerCarteCredit(string $nomChamp, array $tableauValidation):array
    {

        $contenuBruteFichierJson = file_get_contents("../ressources/lang/fr_CA.UTF-8/messagesValidation.json");
        $tMessagesJson = json_decode($contenuBruteFichierJson, true); // Convertir en tableau associatif

        $valeurPost = '';
        $valide = false;
        $message = '';
        $typeCarte = null;


        if(isset($_POST[$nomChamp])){

            $valeurPost = trim($_POST[$nomChamp]);

            if($valeurPost == ''){

                $message = $tMessagesJson[$nomChamp]['vide'];

            } else {

                $motifAmex = "#^[3][0-9]{2}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#";
                $motifMasterCard = "#^[5][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#";
                $motifVisa = "#^[4][0-9]{3}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#";

                $trouveAmex = preg_match(($motifAmex),$valeurPost);
                $trouveMasterCard = preg_match(($motifMasterCard),$valeurPost);
                $trouveVisa = preg_match(($motifVisa),$valeurPost);

                if($trouveAmex){
                    $typeCarte = 'American Express';
                    $valide=true;
                }elseif($trouveMasterCard){
                    $typeCarte = 'Master Card';
                    $valide=true;
                }elseif($trouveVisa) {
                    $typeCarte = 'VISA';

                    $valide=true;
                }else {
                    $message = $tMessagesJson[$nomChamp]['pattern'];
                }

            }

        } else {

            $message = $tMessagesJson[$nomChamp]['vide'];

        }

        $tableauValidation[$nomChamp] = ['valeur' => $valeurPost, 'blnValide' => (bool)$valide, 'messageErreur' => $message ,'typeCarte'=>$typeCarte];
        return $tableauValidation;


    }




}