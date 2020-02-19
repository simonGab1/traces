@extends('transaction.gabaritTransaction')

@section('contenu')

    @include('transaction.fragments.navTransaction')

    <div class="conteneurForm conteneurTransaction">
        <h1 class="connexion__h1">Livraison</h1>
        <form class="formFlex creer" action="index.php?controleur=livraison&action=inserer" method="post">
            <div class="bg_connexion formFlex">
                <h2>Adresse de livraison</h2>
                <div class="alignInput creer__item">
                    <label for="nom">Nom</label>
                    <input @if($sessionLivraison!==null && $sessionLivraison['nom']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif type="text" id="nom" name="nom"

                           @if($sessionLivraison===null)
                           value="{{$adresse->nom}}"
                           @else
                           value="{{$sessionLivraison['nom']['valeur']}}"
                           @endif
                           pattern="^[a-zA-ZÀ-ÿ -]+$">
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['nom']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['nom']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <div class="alignInput creer__item">
                    <label for="prenom">Prénom</label>
                    <input @if($sessionLivraison!==null && $sessionLivraison['prenom']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif

                           @if($sessionLivraison===null)
                           value="{{$adresse->prenom}}"
                           @else
                           value="{{$sessionLivraison['prenom']['valeur']}}"
                           @endif
                           type="text"
                           id="prenom"
                           name="prenom"
                           pattern="^[a-zA-ZÀ-ÿ -]+$">
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['prenom']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['prenom']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <div class="alignInput creer__item">
                    <label for="adresse">Adresse</label>
                    <input @if($sessionLivraison!==null && $sessionLivraison['adresse']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif
                           type="text" id="adresse" name="adresse"
                           @if($sessionLivraison===null)
                           value="{{$adresse->adresse}}"
                           @else
                           value="{{$sessionLivraison['adresse']['valeur']}}"
                           @endif
                           pattern="^[0-9]+[a-zA-ZÀ-ÿ0-9\'\, \-]+$">
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['adresse']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['adresse']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <div class="alignInput creer__item">
                    <label for="ville">Ville</label>
                    <input @if($sessionLivraison!==null && $sessionLivraison['ville']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif
                           type="text" id="ville" name="ville"
                           @if($sessionLivraison===null)
                           value="{{$adresse->ville}}"
                           @else
                           value="{{$sessionLivraison['ville']['valeur']}}"
                           @endif
                           pattern="^[a-zA-ZÀ-ÿ \-]+$">
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['ville']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['ville']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>

                <div class="alignInput creer__item">
                    <label for="pays">Pays/Province&nbsp;ou&nbsp;État&nbsp;</label>
                    <select @if($sessionLivraison!==null && $sessionLivraison['province']['blnValide']===true)
                            class="inputGeneral menuDeroulant success"
                            @else
                            class="inputGeneral menuDeroulant"
                            @endif
                            name="province" id="pays">
                        <option value="">Choisir une option...</option>
                        @foreach($provinces as $province)
                            <option value="{{$province->abbr_province}}"
                                    @if($sessionLivraison===null)
                                    @if($adresse->abbr_province == $province->abbr_province)
                                    selected="selected"
                                    @endif
                                    @else
                                    @if($sessionLivraison['province']['valeur'] == $province->abbr_province)
                                    selected="selected"
                                    @endif
                                    @endif>
                                {{$province->nom}}
                            </option>
                        @endforeach
                    </select>
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['province']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['province']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>
                <div class="alignInput creer__item">
                    <label for="code_postal">Code postal <span class="indice">Ex: A1A 1A1</span></label>
                    <input @if($sessionLivraison!==null && $sessionLivraison['code_postal']['blnValide']===true)
                           class="inputGeneral inputGeneral--petit success"
                           @else
                           class="inputGeneral inputGeneral--petit"
                           @endif
                           type="text" id="code_postal"
                           @if($sessionLivraison===null)
                           value="{{$adresse->code_postal}}"
                           @else
                           value="{{$sessionLivraison['code_postal']['valeur']}}"
                           @endif
                           name="code_postal"
                           maxlength="7"
                           pattern="^[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]$">
                    @if($sessionLivraison!==null)
                        @if($sessionLivraison['code_postal']['blnValide']===false)
                            <span class="erreur">{{$sessionLivraison['code_postal']['messageErreur']}}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div>
                <div class="checkbox">
                    <input type="checkbox" name="adresse_defaut" id="adresse_defaut" value="1"
                           @if($sessionLivraison!==null)
                           @if($sessionLivraison['adresse_defaut']['valeur']==='1')
                           checked
                           @endif
                           @else
                           checked
                            @endif >
                    <label for="adresse_defaut">Adresse de livraison par défaut</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="adresse_facturation" id="adresse_facturation" value="facturation"
                           @if($sessionLivraison!==null)
                           @if($sessionLivraison['adresse_facturation']['valeur']==='facturation')
                           checked
                           @endif
                           @else
                           checked
                            @endif >
                    <label for="adresse_facturation">Utiliser comme adresse de facturation</label>
                </div>
                <button class="btn" type="submit" name="btn_submit" value="on">Livrer à cette adresse</button>
            </div>
        </form>
    </div>




@endsection

