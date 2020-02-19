@extends('courriels.gabarit')

@section('contenu')
    <h1>Nous avons bien reçu votre commande.</h1>


    <div class="confirmation__bg">
        <h2 class="confirmation__h2">Sommaire de votre commande</h2>
        <ul>
            <li>
                <span>{{$nbrTotalItems}} items :</span>
                <span>{!!number_format($montantSousTotal,2, '.', '')!!} $</span>
            </li>
            <li>
                <span>TPS 5% : </span>
                <span>{!!number_format($montantTPS,2, '.', '')!!} $</span>
            </li>
            <li>
                <span>Livraison standard : </span>
                <span>{!!number_format($montantFraisLivraison,2, '.', '')!!} $</span>
            </li>
            <li>
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
            <svg class="confirmation__iconNumero">
                <use xlink:href="#visa"/>
            </svg>
            <span class="confirmation__cc">XXXX XXXX XXXX 1234</span>
        </div>
    </div>
    <div class="confirmation__bg">
        <h2 class="confirmation__h2">Informations</h2>
        <span>{{$client->courriel}}</span>
        <span>{{$client->telephone}}</span>
    </div>

@endsection

