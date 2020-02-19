<div class="panier__info">
    @if($nbrArticles > 0)

        <ul class="panier__infos">
            <li class="panier__infos--section">
                <p>Sous-total (<span class="nbrItem">{{$nbrArticles}}</span>)</p>
                <p class="sousTotal"> CAD {!!number_format($sousTotal,2, '.', '')!!} $ </p>
            </li>
            <li class="panier__infos--section">
                <p>TPS (5%)</p>
                <p class="tps"> CAD {!!number_format($sessionPanier->getMontantTps(),2, '.', '')!!} $ </p>
            </li>
            <li class="panier__infos--section">
                <p>Livraison</p>
                <p class="livraison"> CAD {!!number_format($sessionPanier->getMontantFraisLivraison(),2, '.', '')!!}
                    $</p>
            </li>
            <form method="post" action="index.php?controleur=panier&action=majLivraison">
                <select class="inputGeneral menuDeroulant" name="modesLivraison" id="livraison">
                    @foreach($modesLivraison as $livraison)
                        @if($sousTotal > 50)
                            <option class="{{$livraison->mode_livraison}}" value="{{$livraison->id_mode_livraison}}"
                                    @if($sessionPanier->getModeLivraison() !== '')
                                    @if($livraison->id_mode_livraison === $sessionPanier->getModeLivraison()->id_mode_livraison)
                                    selected
                                    @endif
                                    @endif
                            >
                                {{$livraison->mode_livraison . ' ( ' . $livraison->delai . ' ) '}}
                            </option>
                        @else
                            @if($livraison->mode_livraison != 'gratuite')

                                <option class="{{$livraison->mode_livraison}}" value="{{$livraison->id_mode_livraison}}"
                                        @if($sessionPanier->getModeLivraison() !== '')
                                        @if($livraison->id_mode_livraison === $sessionPanier->getModeLivraison()->id_mode_livraison)
                                        selected
                                        @endif
                                        @endif
                                >
                                    {{$livraison->mode_livraison . ' ( ' . $livraison->delai . ' ) '}}
                                </option>
                            @endif
                        @endif
                    @endforeach
                </select>
                <input type="hidden" name="pageActive" value="{{$pageActive}}">
                <input class="btn btnHidden" type="submit" value="Mettre à jour">
            </form>
            @if($sessionPanier->getModeLivraison() === '')
                <p class="jourLivraisonGratuite">date de livraison estimée : <span
                            class="jourLivraisonGratuite">{{$sessionPanier->calculerDateLivraisonGratuit()}}</span></p>
            @else
                <p>date de livraison estimée : <span
                            class="jourLivraison">{{$sessionPanier->getModeLivraison()->calculerDateLivraison()}}</span
                </p>

            @endif
            <hr align="right" class="panier__infos--separation">
            <li class="panier__infos--section">
                <p class="panier__infos--section--prixtotal">Total</p>
                <p class="panier__infos--section--prixtotal total">
                    CAD {!!number_format($sessionPanier->getMontantTotal(),2, '.', '')!!} $</p>
            </li>
        </ul>
    @endif
</div>
