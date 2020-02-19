@extends('gabarit')

@section('contenu')
    <div class="conteneurForm">
        <h1 class="connexion__h1">Connectez-vous</h1>
        <div class="bg_connexion">
            <form class="formFlex connexion" action="index.php?controleur=compte&action=validationConnexion" method="post" novalidate>
                <div class="alignInput connexion__item">
                    <label for="courrielconnexion">Courriel</label>
                    <input
                            @if($tnewConnexion['courrielconnexion']['blnValide']===true)
                            class="inputGeneral success"
                            @endif
                            @if($tnewConnexion['courrielconnexion']['blnValide']===false)
                            class="inputGeneral erreurInput"
                            @endif
                            @if($tnewConnexion['courrielconnexion']['blnValide']===null)
                            class="inputGeneral"
                            @endif
                            id="courrielconnexion" name="courrielconnexion" type="text"
                            @if(!$tnewConnexion)
                            value=""
                            @else
                            value="{{$tnewConnexion['courrielconnexion']['valeur']}}"
                            @endif>
                    @if($tnewConnexion)
                        @if($tnewConnexion['courrielconnexion']['blnValide']===false)
                            <span class="erreur">{{$tnewConnexion['courrielconnexion']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <div class="alignInput connexion__item">
                    <label for="motdepasseconnexion">Mot de passe</label>
                    <input
                            @if($tnewConnexion['motdepasseconnexion']['blnValide']===true)
                            class="inputGeneral success"
                            @endif
                            @if($tnewConnexion['motdepasseconnexion']['blnValide']===false)
                            class="inputGeneral erreurInput"
                            @endif
                            @if($tnewConnexion['motdepasseconnexion']['blnValide']===null)
                            class="inputGeneral"
                            @endif
                            type="password" name="motdepasseconnexion" id="motdepasseconnexion"
                            @if(!$tnewConnexion)
                            value=""
                            @else
                            value="{{$tnewConnexion['motdepasseconnexion']['valeur']}}"
                            @endif>
                    @if($tnewConnexion)
                        @if($tnewConnexion['motdepasseconnexion']['blnValide']===false)
                            <span class="erreur">{{$tnewConnexion['motdepasseconnexion']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <button class="btn" type="submit">Se connecter</button>
            </form>
            <span class="connexion__creer" >Vous n'avez pas de compte ? <a class="lienStyle" href="index.php?controleur=compte&action=creercompte">Se créer un compte</a></span>
        </div>
    </div>
@endsection