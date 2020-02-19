<?php
declare(strict_types=1);

namespace App\Courriels;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\App;


class CourrielConfirmation
{

    private $courriel = null;
    private $client = null;


    public function __construct(string $unCourriel, $client, $sessionPanier, $sessionLivraison, $sessionFacturation, $nbrTotalItems, $montantSousTotal, $montantTPS, $montantFraisLivraison, $montantTotal){

        // Préparer le contenu HTML du courriel

        $this->client = $client;
        $sousTotal = App::getInstance()->getSessionPanier()->getMontantSousTotal();
        $nbrArticles = App::getInstance()->getSessionPanier()->getNombreTotalItems();


        $tDonnees = array("nomPage" => "courriel confirmation");
        $tDonnees = array_merge($tDonnees, array("sousTotal" => $sousTotal));
        $tDonnees = array_merge($tDonnees, array("nbrArticles" => $nbrArticles));
        $tDonnees = array_merge($tDonnees, array("client" => $this->client));
        $tDonnees = array_merge($tDonnees, array("sessionPanier" => $sessionPanier));
        $tDonnees = array_merge($tDonnees, array("sessionLivraison" => $sessionLivraison));
        $tDonnees = array_merge($tDonnees, array("sessionFacturation" => $sessionFacturation));

        $tDonnees = array_merge($tDonnees, array("nbrTotalItems" => $nbrTotalItems));
        $tDonnees = array_merge($tDonnees, array("montantSousTotal" => $montantSousTotal));
        $tDonnees = array_merge($tDonnees, array("montantTPS" => $montantTPS));
        $tDonnees = array_merge($tDonnees, array("montantFraisLivraison" => $montantFraisLivraison));
        $tDonnees = array_merge($tDonnees, array("montantTotal" => $montantTotal));

        $blade = App::getInstance()->getBlade();
        $unContenuHTML = $blade->run("courriels.courrielConfirmation", $tDonnees);
        $unContenuHTML_enTexte = 'Votre commande a bien été recu';


        $this->courriel = new PHPMailer(true); // True indique que les exceptions seront lancées (Throwable) et non retourné en valeur retour de la méthode send


        //Configuration du serveur d'envoi
        $this->courriel->SMTPDebug  = 0;                                      // Activer le débogage 0 = off, 1 = messages client, 2 = messages client et serveur
        $this->courriel->isSMTP();                                            // Envoyer le courriel avec le protocole standard SMTP
        $this->courriel->Host       = 'smtp.gmail.com';                    // Adresse du serveur d'envoi SMTP
        $this->courriel->SMTPAuth   = true;                                   // Activer l'authentification SMTP
        $this->courriel->Username   = 'librariestraces@gmail.com';           // Nom d'utilisateur SMTP
        $this->courriel->Password   = 'Singerouge3!';                         // Mot de passe SMTP
        $this->courriel->SMTPSecure = 'TLS';                                  // Activer l'encryption TLS, `PHPMailer::ENCRYPTION_SMTPS` est aussi accepté
        $this->courriel->Port       = 587;                                    // Port TCP à utiliser pour la connexion SMTP

        // Configuration du courriel

        // De:
        $this->courriel->setFrom('librariestraces@gmail.com'); // Définir l'adresse de l'envoyeur.

        // À:
        $this->courriel->addAddress($unCourriel);      // Ajouter l'adresse du destinataire (le nom est optionel)

        // Contenu:
        $this->courriel->isHTML(true);  // Définir le type de contenu du courriel.
        $this->courriel->Subject = 'Confirmation de commande - Librarie Traces';
        $this->courriel->Body    = $unContenuHTML;
        $this->courriel->AltBody = $unContenuHTML_enTexte; // Si le client ne supporte pas le courriels HTML


        $this->envoyer();
    }

    public function envoyer():string
    {
        try {
            $this->courriel->send();
            return "Le message a été envoyé.";
        } catch (Exception $e) {
            // Gérer les exceptions spécifique à PHPMailer
            return  "Le message ne peut pas être envoyé.";

        }catch (\Exception $e) {
            // Gérer les exeptions internes de PHP
            return "Le message ne peut pas être envoyé.";
        }
    }

}

