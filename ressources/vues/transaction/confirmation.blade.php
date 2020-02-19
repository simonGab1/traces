@extends('transaction.gabaritTransaction')

@section('contenu')

    @if($idCommande)
    <div id="sectionImpression">

        <h1 class="confirmation__h1">Nous avons bien reçu votre commande.</h1>
        <div>
            <p class="confirmation__texte">Elle vous sera expédiée selon les modalités que vous avez choisies. N’hésitez pas à consulter notre service à la clientèle pour plus d’informations relatives à votre commande ou votre compte.</p>

            <div class="confirmation__flexIcon">
                <svg class="confirmation__iconNumero">
                    <use xlink:href="#confirmation"/>
                </svg>
                <span class="confirmation__numero">
            Votre numéro de confirmation est le: {{$idCommande}}.
            </span>
            </div>
            <div class="confirmation__flexIcon">
                <svg class="confirmation__iconEmail">
                    <use xlink:href="#email"/>
                </svg>
                <p class="confirmation__courriel">Vous recevrez d’ici quelques minutes une confirmation de votre commande par courriel.</p>
            </div>
        </div>

        <div class="impression__conteneur">
            <div class="confirmation__bg">
                <h2 class="confirmation__h2">Sommaire de votre commande</h2>
                @include('transaction.fragments.fichePanierConfirmation')
                <ul class="confirmation__sommaire">
                    <li class="confirmationPanier__totalFlex">
                        <span>{{$nbrTotalItems}} items :</span>
                        <span>{!!number_format($montantSousTotal,2, '.', '')!!} $</span>
                    </li>
                    <li class="confirmationPanier__totalFlex">
                        <span>TPS 5% : </span>
                        <span>{!!number_format($montantTPS,2, '.', '')!!} $</span>
                    </li>
                    <li class="confirmationPanier__totalFlex">
                        <span>Livraison standard : </span>
                        <span>{!!number_format($montantFraisLivraison,2, '.', '')!!} $</span>
                    </li>
                    <li class="confirmationPanier__totalFlex">
                        <span>Total : </span>
                        <span>{!!number_format($montantTotal,2, '.', '')!!} $</span>
                    </li>
                </ul>
            </div>
            <div class="confirmation__bg">
                <h2 class="confirmation__h2">Adresse de livraison</h2>
                <ul>
                    <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
                    <li>{{$sessionLivraison['adresse']['valeur']}}</li>
                    <li>{{$sessionLivraison['ville']['valeur']}}, {{$sessionLivraison['province']['valeur']}}</li>
                    <li>{{$sessionLivraison['code_postal']['valeur']}}</li>
                </ul>
            </div>
            <div class="confirmation__bg">
                <h2 class="confirmation__h2">Adresse de facturation</h2>
                @if($sessionLivraison['adresse_facturation']['valeur']!=='facturation')
                    <ul>
                        <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
                        <li>{{$sessionFacturation['adresse']['valeur']}}</li>
                        <li>{{$sessionFacturation['ville']['valeur']}}, {{$sessionFacturation['province']['valeur']}}</li>
                        <li>{{$sessionFacturation['code_postal']['valeur']}}</li>
                    </ul>
                @else
                    <ul>
                        <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
                        <li>{{$sessionLivraison['adresse']['valeur']}}</li>
                        <li>{{$sessionLivraison['ville']['valeur']}}, {{$sessionLivraison['province']['valeur']}}</li>
                        <li>{{$sessionLivraison['code_postal']['valeur']}}</li>
                    </ul>
                @endif
            </div>
            <div class="confirmation__bg">
                <h2 class="confirmation__h2">Mode de paiement</h2>
                <span>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</span>
                <div class="confirmation__flexIcon">
                    @switch($sessionFacturation['numCredit']['typeCarte'])
                        @case('VISA')
                        <svg class="confirmation__iconNumero">
                            <use xlink:href="#visa"/>
                        </svg>
                        @break
                        @case('Master Card')
                        <svg class="confirmation__iconNumero">
                            <use xlink:href="#mastercard"/>
                        </svg>
                        @break
                        @case('American Express')
                        <svg class="confirmation__iconNumero">
                            <use xlink:href="#amex"/>
                        </svg>
                        @break
                    @endswitch
                    <span class="confirmation__cc">XXXX XXXX XXXX {{substr($sessionFacturation['numCredit']['valeur'],-4,4)}}</span>
                </div>
            </div>
            <div class="confirmation__bg">
                <h2 class="confirmation__h2">Informations</h2>
                <span class="confirmation__info">Courriel : {{$client->courriel}}</span>
                <span class="confirmation__info">Telephone : {{$client->telephone}}</span>
            </div>

        </div>
    </div>

    <input type="button" class="btn" id="BtnImpression" onclick="printDiv('sectionImpression')" value="Imprimer le reçu de votre commande">
    <a class="confirmation__lien" href="index.php?controleur=livre&action=index">Continuer à magasiner</a>

    @else
    <div class="confirmationVide">
        <h1 class="confirmationVide__h1">Merci d'avoir magasiné chez nous</h1>
        <p class="confirmation__texte">Votre commande vous sera expédiée selon les modalités que vous avez choisies. N’hésitez pas à consulter notre service à la clientèle pour plus d’informations relatives à votre commande ou votre compte.</p>
    </div>

    <a class="confirmation__lien" href="index.php?controleur=livre&action=index">Continuer à magasiner</a>

    @endif
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

@endsection