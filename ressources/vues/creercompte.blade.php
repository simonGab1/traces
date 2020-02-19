@extends('gabarit')

@section('contenu')


    <div class="conteneurForm">
        <h1 class="connexion__h1">Créer un compte</h1>
        <div class="bg_connexion">
            <form class="formFlex creer" action="index.php?controleur=compte&action=validationInscription" method="post" novalidate>
                <div class="alignInput creer__item">
                    <label for="nom">Nom</label>
                    <input @if($tnewClient['nom']['blnValide']===true)
                           class="inputGeneral success"
                           @endif
                           @if($tnewClient['nom']['blnValide']===false)
                           class="inputGeneral erreurInput"
                           @endif
                           @if($tnewClient['nom']['blnValide']===null)
                           class="inputGeneral"
                           @endif
                            id="nom" name="nom" type="text"
                           @if(!$tnewClient)
                           value=""
                           @else
                           value="{{$tnewClient['nom']['valeur']}}"
                           @endif
                            pattern="^[a-zA-ZÀ-ÿ-]+$"
                    >
                    @if($tnewClient)
                        @if($tnewClient['nom']['blnValide']===false)
                            <span class="erreur">{{$tnewClient['nom']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur" id="messageNom"></span>
                </div>

                <div class="alignInput creer__item">
                    <label for="prenom">Prénom</label>
                    <input @if($tnewClient['prenom']['blnValide']===true)
                           class="inputGeneral success"
                           @endif
                           @if($tnewClient['prenom']['blnValide']===false)
                           class="inputGeneral erreurInput"
                           @endif
                           @if($tnewClient['prenom']['blnValide']===null)
                           class="inputGeneral"
                           @endif
                           id="prenom" name="prenom" type="text"
                           @if(!$tnewClient)
                           value=""
                           @else
                           value="{{$tnewClient['prenom']['valeur']}}"
                            @endif
                           pattern="^[a-zA-ZÀ-ÿ' -]+$"
                    >
                    @if($tnewClient)
                        @if($tnewClient['prenom']['blnValide']===false)
                            <span class="erreur">{{$tnewClient['prenom']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>
                </div>

                <div class="alignInput creer__item">
                    <label for="courriel">Courriel</label>
                    <input @if($tnewClient['courriel']['blnValide']===true)
                           class="inputGeneral success"
                           @endif
                           @if($tnewClient['courriel']['blnValide']===false)
                           class="inputGeneral erreurInput"
                           @endif
                           @if($tnewClient['courriel']['blnValide']===null)
                           class="inputGeneral"
                           @endif
                           id="courriel" name="courriel" type="text"
                           @if(!$tnewClient)
                           value=""
                           @else
                           value="{{$tnewClient['courriel']['valeur']}}"
                            @endif
                           pattern="^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$"
                    >
                    @if($tnewClient)
                        @if($tnewClient['courriel']['blnValide']===false)
                            <span class="erreur">{{$tnewClient['courriel']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span id="AjaxCourriel" class="messageErreur"></span>
                </div>

                <div class="alignInput creer__item">
                    <label for="telephone">Téléphone (4189990000)</label>
                    <input @if($tnewClient['telephone']['blnValide']===true)
                           class="inputGeneral success"
                           @endif
                           @if($tnewClient['telephone']['blnValide']===false)
                           class="inputGeneral erreurInput"
                           @endif
                           @if($tnewClient['telephone']['blnValide']===null)
                           class="inputGeneral"
                           @endif
                           id="telephone" name="telephone" type="text"
                           @if(!$tnewClient)
                           value=""
                           @else
                           value="{{$tnewClient['telephone']['valeur']}}"
                            @endif
                           pattern="^([(+]*[0-9]+[()+. -]*)$"
                           maxlength="10"
                    >
                    @if($tnewClient)
                        @if($tnewClient['telephone']['blnValide']===false)
                            <span class="erreur">{{$tnewClient['telephone']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>
                </div>

                <div class="alignInput creer__item">
                    <label for="motdepasse">Mot de passe</label>
                    <input @if($tnewClient['motdepasse']['blnValide']===true)
                           class="inputGeneral success"
                           @endif
                           @if($tnewClient['motdepasse']['blnValide']===false)
                           class="inputGeneral erreurInput"
                           @endif
                           @if($tnewClient['motdepasse']['blnValide']===null)
                           class="inputGeneral"
                           @endif
                           id="motdepasse" name="motdepasse" type="text"
                           @if(!$tnewClient)
                           value=""
                           @else
                           value="{{$tnewClient['motdepasse']['valeur']}}"
                            @endif
                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,10}$"
                    >
                    @if($tnewClient)
                        @if($tnewClient['motdepasse']['blnValide']===false)
                            <span class="erreur">{{$tnewClient['motdepasse']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>
                </div>
                <button class="btn" type="submit">Créer un compte</button>
            </form>
            <span class="connexion__creer" >Vous avez déjà un compte ? <a class="lienStyle" href="index.php?controleur=compte&action=connexion">Se connecter</a></span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
@endsection