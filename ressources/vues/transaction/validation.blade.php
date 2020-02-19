@extends('transaction.gabaritTransaction')

@section('contenu')


    @include('transaction.fragments.navTransaction')

    <div class="conteneurForm conteneurTransaction">
        <h1>Validation de la commande</h1>
        <div class="formFlex creer" >


            <a class="btnLien" href="index.php?controleur=validation&action=confirmation" name="btn_submit" >Passer la commande</a>

        <p>Livraison à <strong>{{$client->prenom}} {{$client->nom}}</strong></p>

            @if($sessionPanier->getModeLivraison() === '')
                <p>Date de livraison estimée <strong>{{$sessionPanier->calculerDateLivraisonGratuit()}}</strong></p>
            @else
                <p>Date de livraison estimée <strong>{{$sessionPanier->getModeLivraison()->calculerDateLivraison()}}</strong></p>

            @endif


            <div class="bg_transaction formFlex">

            <h2>Sommaire de la commande</h2>
                <ul>
            <li>{{$sessionPanier->getNombreTotalItems()}} items : {!!number_format($sessionPanier->getMontantSousTotal(),2, '.', '')!!} $</li>
            <li>TPS 5% : {!!number_format($sessionPanier->getMontantTPS(),2, '.', '')!!} $</li>
            <li>Livraison standard :  {!!number_format($sessionPanier->getMontantFraisLivraison(),2, '.', '')!!} $</li>
            <li>TOTAL : <strong>{!!number_format($sessionPanier->getMontantTotal(),2, '.', '')!!} $</strong></li>
                </ul>

            </div>
        <div class="bg_transaction formFlex">
            <h2>Adresse de livraison</h2>
            <ul>
            <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
            <li>{{$sessionLivraison['adresse']['valeur']}}</li>
            <li>{{$sessionLivraison['ville']['valeur']}}, {{$sessionLivraison['province']['valeur']}}</li>
            <li>{{$sessionLivraison['code_postal']['valeur']}}</li>
            </ul>
            <a href="index.php?controleur=livraison&action=livraison" class="btnLien btnLien--droite">Modifier</a>
        </div>

        <div class="bg_transaction formFlex">
            <h2>Informations de facturation</h2>
            <div class="conteneurInfoFacturation">
                <h3 class="validation__h3">Mode de paiement </h3>
                <div class="confirmation__flexIcon">
                    @switch($sessionFacturation['numCredit']['typeCarte'])
                        @case('VISA')
                        <svg class="facturation__iconNumero">
                            <use xlink:href="#visa"/>
                        </svg>
                        @break
                        @case('Master Card')
                        <svg class="facturation__iconNumero">
                            <use xlink:href="#mastercard"/>
                        </svg>
                        @break
                        @case('American Express')
                        <svg class="facturation__iconNumero">
                            <use xlink:href="#amex"/>
                        </svg>
                        @break
                    @endswitch
                    <ul class="confirmation__cc">
                        <li>XXXX XXXX XXXX {{substr($sessionFacturation['numCredit']['valeur'],-4,4)}}</li>
                        <li>Expiration {{$sessionFacturation['expiration']['mois']}} / {{$sessionFacturation['expiration']['annee']}} </li>
                    </ul>
                </div>
                <a href="index.php?controleur=facturation&action=facturation" class="btnLien btnLien--droite">Modifier</a>
            </div>
            <div class="conteneurInfoFacturation">
                <h3 class="validation__h3">Adresse de facturation</h3>
                @if($sessionLivraison['adresse_facturation']['valeur']!=='facturation')
                    <ul>
                        <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
                        <li>{{$sessionFacturation['adresse']['valeur']}}</li>
                        <li>{{$sessionFacturation['ville']['valeur']}}, {{$sessionFacturation['province']['valeur']}}</li>
                        <li>{{$sessionFacturation['code_postal']['valeur']}}</li>
                    </ul>
                    <a href="index.php?controleur=facturation&action=facturation" class="btnLien btnLien--droite">Modifier</a>
                @else
                    <ul>
                        <li>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</li>
                        <li>{{$sessionLivraison['adresse']['valeur']}}</li>
                        <li>{{$sessionLivraison['ville']['valeur']}}, {{$sessionLivraison['province']['valeur']}}</li>
                        <li>{{$sessionLivraison['code_postal']['valeur']}}</li>
                    </ul>
                    <a href="index.php?controleur=livraison&action=livraison" class="btnLien btnLien--droite">Modifier</a>
                @endif
            </div>

            <div class="conteneurInfoFacturation">
                <h3 class="validation__h3">Informations</h3>
                <ul>
                    <li>Courriel : {{$client->courriel}}</li>
                    <li>Téléphone : {{$client->telephone}}</li>
                </ul>
                <a href="#" class="btnLien btnLien--droite">Modifier</a>
            </div>

        </div>

            <h2>Mon Panier</h2>

            @include('panier.fragments.fichedupanier')

            @include('panier.fragments.montantsPanier')

            <a class="btnLien" href="index.php?controleur=validation&action=confirmation" name="btn_submit" >Passer la commande</a>
    </div>
    </div>



@endsection

