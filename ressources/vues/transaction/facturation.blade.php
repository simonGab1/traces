@extends('transaction.gabaritTransaction')

@section('contenu')


    @include('transaction.fragments.navTransaction')


    <div class="conteneurForm conteneurTransaction">
        <h1>Facturation</h1>
        <form class="formFlex creer" action="index.php?controleur=facturation&action=inserer" method="post">
            <div class="bg_transaction formFlex">
                <h2>Informations de paiement</h2>
                <div class="alignInput creer__item">
                    <div class="checkbox facturation__checkbox">
                        <div class="choixPaiement">
                            <input class="inputGeneral" required type="radio" name="paiement" value="paypal" id="paypal"
                                   disabled="disabled"
                                   @if($sessionFacturationExist!==false && $facturation['paiement']['valeur']==="paypal")
                                   checked
                                    @endif>
                            <label for="paypal">Paypal</label>
                        </div>

                        <div class="choixPaiement">
                            <input class="inputGeneral" required type="radio" name="paiement" value="credit" id="credit"
                                   checked>
                            <label for="credit">Carte de crédit</label>
                        </div>
                        @if($sessionFacturationExist!==false)
                            @if($facturation['paiement']['blnValide']===false)
                                <span class="erreur">{{$facturation['paiement']['messageErreur']}}</span>
                            @endif
                        @endif
                    </div>

                </div>


                <div class="facturation__typeCarte">
                    <p>Cartes de crédits accéptés</p>
                    <svg class="facturation__iconNumero">
                        <use xlink:href="#visa"/>
                    </svg>
                    <svg class="facturation__iconNumero">
                        <use xlink:href="#mastercard"/>
                    </svg>
                    <svg class="facturation__iconNumero">
                        <use xlink:href="#amex"/>
                    </svg>
                </div>

                <div class="alignInput creer__item">
                    <label for="nomtitulaire">Nom</label>
                    <input @if($sessionFacturationExist!==false && $facturation['nomtitulaire']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif

                           @if($sessionFacturationExist===false)
                           value="{{$facturation->nom_complet}}"
                           @else
                           value="{{$facturation['nomtitulaire']['valeur']}}"
                           @endif

                           type="text"
                           id="nomtitulaire"
                           name="nomtitulaire"
                           pattern="^[a-zA-ZÀ-ÿ' -]{2,}$"
                           required>
                    @if($sessionFacturationExist!==false)
                        @if($facturation['nomtitulaire']['blnValide']===false)
                            <span class="erreur">{{$facturation['nomtitulaire']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>
                </div>

                <div class="alignInput creer__item">
                    <label for="numCredit">Numéro de la carte</label>
                    <input @if($sessionFacturationExist!==false && $facturation['numCredit']['blnValide']===true)
                           class="inputGeneral success"
                           @else
                           class="inputGeneral"
                           @endif
                           @if($sessionFacturationExist===false)
                           value="{{$facturation->no_carte}}"
                           @else
                           value="{{$facturation['numCredit']['valeur']}}"
                           @endif
                           type="text"
                           id="numCredit"
                           name="numCredit"
                           required>
                    @if($sessionFacturationExist!==false)
                        @if($facturation['numCredit']['blnValide']===false)
                            <span class="messageErreur erreur">{{$facturation['numCredit']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>

                </div>

                <div class="alignInput creer__item">
                    <label for="codeSecurite">Code de sécurité</label>
                    <input @if($sessionFacturationExist!==false && $facturation['codeSecurite']['blnValide']===true)
                           class="inputGeneral inputGeneral--petit success"
                           @else
                           class="inputGeneral inputGeneral--petit"
                           @endif
                           @if($sessionFacturationExist===false)
                           value="{{$facturation->code}}"
                           @else
                           value="{{$facturation['codeSecurite']['valeur']}}"
                           @endif
                           type="text"
                           id="codeSecurite"
                           name="codeSecurite"
                           pattern="^[0-9]{3}$"
                           maxlength="3"
                           required>
                    @if($sessionFacturationExist!==false)
                        @if($facturation['codeSecurite']['blnValide']===false)
                            <span class="messageErreur erreur">{{$facturation['codeSecurite']['messageErreur']}}</span>
                        @endif
                    @endif
                    <span class="messageErreur"></span>

                </div>


                <label for="expirationMois">Date d'expiration<span class="indice"> MM AAAA</span></label>
                <div class="dateExpiration">
                    <div class=" creer__item">
                        <select @if($sessionFacturationExist!==false && $facturation['expiration']['blnValide']===true)
                                class="inputGeneral menuDeroulant success"
                                @else
                                class="inputGeneral menuDeroulant"
                                @endif
                                name="mois" id="expirationMois" required>
                            <option value="">MM</option>

                            @for($cpt = 1;$cpt<13 ;$cpt++)
                                <option value="{{sprintf('%02d',$cpt)}}"
                                        @if($sessionFacturationExist===false)
                                        @if($facturation->moisExpiration() == sprintf('%02d',$cpt))
                                        selected="selected"
                                        @endif
                                        @else
                                        @if($facturation['expiration']['mois'] == sprintf('%02d',$cpt))
                                        selected="selected"
                                        @endif
                                        @endif>
                                    {{sprintf('%02d',$cpt)}}
                                </option>
                            @endfor

                        </select>
                    </div>
                    <div class=" creer__item">
                        <select @if($sessionFacturationExist!==false && $facturation['expiration']['blnValide']===true)
                                class="inputGeneral menuDeroulant success"
                                @else
                                class="inputGeneral menuDeroulant"
                                @endif
                                name="annee" id="expirationAnnee" required>
                            <option value="">AAAA</option>

                            @for($cpt = 2017;$cpt<2025 ;$cpt++)
                                <option value="{{$cpt}}"
                                        @if($sessionFacturationExist===false)
                                        @if($facturation->anneeExpiration() == $cpt)
                                        selected="selected"
                                        @endif
                                        @else
                                        @if($facturation['expiration']['annee'] == $cpt)
                                        selected="selected"
                                        @endif
                                        @endif>
                                    {{$cpt}}
                                </option>
                            @endfor

                        </select>

                    </div>

                </div>
                @if($sessionFacturationExist!==false)
                    @if($facturation['expiration']['blnValide']===false)
                        <span class="messageErreur erreur">{{$facturation['expiration']['messageErreur']}}</span>
                    @endif
                @endif
                <span class="messageErreur"></span>


            </div>
            @if($adresse_facturation!=='facturation')
                <div class="bg_transaction formFlex">
                    <h2>Informations de facturation</h2>

                    <div class="alignInput creer__item">
                        <label for="adresse">Adresse</label>

                        <input @if($sessionFacturationExist!==false)
                               @if(isset($facturation['adresse']))
                               @if($facturation['adresse']['blnValide']===true)
                               class="inputGeneral success"
                               @else
                               class="inputGeneral"
                               @endif
                               @else
                               class="inputGeneral"
                               @endif
                               @else
                               class="inputGeneral"
                               @endif
                               type="text" id="adresse" name="adresse"

                               @if($sessionFacturationExist!==false)
                               @if(isset($facturation['adresse']))
                               value="{{$facturation['adresse']['valeur']}}"
                               @else
                               value=""
                               @endif
                               @else
                               value=""
                               @endif
                               pattern="^[0-9]+[a-zA-ZÀ-ÿ0-9\'\, \-]+$">
                        @if($sessionFacturationExist!==false)
                            @if(isset($facturation['adresse']))
                                @if($facturation['adresse']['blnValide']===false)
                                    <span class="erreur">{{$facturation['adresse']['messageErreur']}}</span>
                                @endif
                            @endif
                        @endif
                        <span class="messageErreur"></span>

                    </div>

                    <div class="alignInput creer__item">
                        <label for="ville">Ville</label>
                        <input @if($sessionFacturationExist!==false)
                               @if(isset($facturation['ville']))
                               @if($facturation['ville']['blnValide']===true)
                               class="inputGeneral success"
                               @else
                               class="inputGeneral"
                               @endif
                               @else
                               class="inputGeneral"
                               @endif
                               @else
                               class="inputGeneral"
                               @endif

                               type="text" id="ville" name="ville"
                               @if($sessionFacturationExist===false)
                               value=""
                               @else
                               @if(isset($facturation['ville']))
                               value="{{$facturation['ville']['valeur']}}"
                               @else
                               value=""
                               @endif
                               @endif
                               pattern="^[a-zA-ZÀ-ÿ \-]+$">
                        @if($sessionFacturationExist!==false)
                            @if(isset($facturation['ville']))
                                @if($facturation['ville']['blnValide']===false)
                                    <span class="erreur">{{$facturation['ville']['messageErreur']}}</span>
                                @endif
                            @endif
                        @endif
                        <span class="messageErreur"></span>

                    </div>

                    <div class="alignInput creer__item">
                        <label for="province">Pays/Province&nbsp;ou&nbsp;État&nbsp;</label>
                        <select @if($sessionFacturationExist!==false)
                                @if(isset($facturation['province']))
                                @if($facturation['province']['blnValide']===true)
                                class="inputGeneral menuDeroulant success"
                                @else
                                class="inputGeneral menuDeroulant"
                                @endif
                                @else
                                class="inputGeneral menuDeroulant"
                                @endif
                                @else
                                class="inputGeneral menuDeroulant"
                                @endif
                                name="province" id="province" value="">
                            <option value="">Choisir une option...</option>
                            @foreach($provinces as $province)
                                <option value="{{$province->abbr_province}}"
                                        @if($sessionFacturationExist===false)

                                        @else
                                        @if(isset($facturation['province']))
                                        @if($facturation['province']['valeur'] == $province->abbr_province)
                                        selected="selected"
                                        @endif
                                        @endif

                                        @endif>
                                    {{$province->nom}}
                                </option>
                            @endforeach
                        </select>
                        @if($sessionFacturationExist!==false)
                            @if(isset($facturation['province']))
                                @if($facturation['province']['blnValide']===false)
                                    <span class="erreur">{{$facturation['province']['messageErreur']}}</span>
                                @endif
                            @endif
                        @endif
                        <span class="messageErreur"></span>

                    </div>
                    <div class="alignInput creer__item">
                        <label for="code_postal">Code postal <span class="indice">Ex: A1A 1A1</span></label>

                        <input
                                @if($sessionFacturationExist!==false)
                                @if(isset($facturation['code_postal']))
                                @if($facturation['code_postal']['blnValide']===true)
                                class="inputGeneral inputGeneral--petit success"
                                @else
                                class="inputGeneral inputGeneral--petit"
                                @endif
                                @else
                                class="inputGeneral inputGeneral--petit"
                                @endif
                                @else
                                class="inputGeneral inputGeneral--petit"
                                @endif
                                type="text" id="code_postal"
                                @if($sessionFacturationExist===false)
                                value=""
                                @else
                                @if(isset($facturation['code_postal']))
                                value="{{$facturation['code_postal']['valeur']}}"
                                @else
                                value=""
                                @endif
                                @endif
                                name="code_postal"
                                maxlength="7"
                                pattern="^[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]$">
                        @if($sessionFacturationExist!==false)
                            @if(isset($facturation['code_postal']))
                                @if($facturation['code_postal']['blnValide']===false)
                                    <span class="erreur">{{$facturation['code_postal']['messageErreur']}}</span>
                                @endif
                            @endif
                        @endif
                        <span class="messageErreur"></span>

                    </div>
                </div>


            @else

                <div class="bg_transaction formFlex">

                    <h2>Adresse de facturation</h2>
                    <span>{{$sessionLivraison['nom']['valeur']}} {{$sessionLivraison['prenom']['valeur']}}</span>
                    <span>{{$sessionLivraison['adresse']['valeur']}}</span>
                    <span>{{$sessionLivraison['ville']['valeur']}}, {{$sessionLivraison['province']['valeur']}}</span>
                    <span>{{$sessionLivraison['code_postal']['valeur']}}</span>
                    <a href="index.php?controleur=livraison&action=livraison" class="btnLien btnLien--droite">Modifier</a>

                </div>

            @endif


            <button class="btn" id="btn_facturation" type="submit" name="btn_submit" >Valider la commande</button>
        </form>
    </div>

@endsection

