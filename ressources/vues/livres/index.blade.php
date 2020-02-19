@extends('gabarit')


@section('contenu')
    <div class="livres conteneur">


        <div class="categories--table">
            <h2>Catégories</h2>
            <p>
                @if($categorieEnCours!==null)
                    <a href="index.php?controleur=livre&action=index">Toutes les Catégories</a>
                @else
                    <span class="categorieActive">Toutes les Catégories</span>
                @endif
            </p>
            <ul>
                @foreach($categories as $categorie)
                    @if($categorieEnCours!==null)
                        @if($categorieEnCours->id==$categorie->id)
                            <li class="categorieActive">{{$categorie->getNomFr()}}</li>
                        @else
                            <li> <a href="{!! $urlLivres . "&categorie=" . $categorie->id !!}">{{$categorie->getNomFr()}}</a></li>
                         @endif
                    @else
                        <li>   <a href="{!! $urlLivres . "&categorie=" . $categorie->id !!}">{{$categorie->getNomFr()}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>



        <div class="catalogue">

            @include('fragments.filAriane')



            @if($categorieEnCours!=null)
                <div class="blockTitre">
                    <h1>{{$categorieEnCours->getNomFr()}}</h1>
                    <span class="onlyMobile">Page {{$numeroPage+1}} de {{$nombreTotalPages+1}}</span>
                </div>
            @else
                @if($nouveautes!=null)
                    <div class="blockTitre">
                        <h1>Nouveautés</h1>
                        <span class="onlyMobile">Page {{$numeroPage+1}} de {{$nombreTotalPages+1}}</span>
                    </div>
                @else
                    <div class="blockTitre">
                        <h1>{{$nomPage}}</h1>
                        <span class="onlyMobile">Page {{$numeroPage+1}} de {{$nombreTotalPages+1}}</span>
                    </div>
                @endif
            @endif


            <div class="catalogue__bar">
                <span class="onlyTable">Page {{$numeroPage+1}} de {{$nombreTotalPages+1}}</span>
                <form class="onlyMobile" action="{{$urlAction}}categorie" method="post">
                    <label for="categorie">Catégories</label>
                    <select class="menuDeroulant" name="categorie" id="categorie" onchange="this.form.submit()">
                        <option value="0">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            @if($categorieEnCours!=null)
                                <option value="{{$categorie->id}}" @if((int)$categorieEnCours->id===(int)$categorie->id) selected @endif>{{$categorie->getNomFr()}}</option>
                            @else
                                <option value="{{$categorie->id}}" >{{$categorie->getNomFr()}}</option>
                            @endif
                        @endforeach
                    </select>
                </form>
                <form class="catalogue__barOptions" action="{{$urlLivresResultats}}" method="post">

                    <ul class="catalogue__barOptionsListe">
                        <li>
                            <label for="nbrLivres">Résultats par pages</label>
                            <select class="menuDeroulant" name="nbrLivres" id="nbrLivres" onchange="this.form.submit()">
                                <option value="8" @if($nbrLivreMaxParPage===8) selected @endif>8</option>
                                <option value="16" @if($nbrLivreMaxParPage===16) selected @endif>16</option>
                                <option value="24" @if($nbrLivreMaxParPage===24) selected @endif>24</option>
                                <option value="48" @if($nbrLivreMaxParPage===48) selected @endif>48</option>
                                <option value="72" @if($nbrLivreMaxParPage===72) selected @endif>72</option>
                            </select>
                        </li>
                        <li>
                            <label for="tri">Tri</label>
                            <select class="menuDeroulant" name="tri" id="tri" onchange="this.form.submit()">
                                <option value="alphaAsc" @if($tri=="alphaAsc") selected @endif>A-Z</option>
                                <option value="alphaDesc" @if($tri=="alphaDesc") selected @endif>Z-A</option>
                                <option value="prixAsc" @if($tri=="prixAsc") selected @endif>$-$$$</option>
                                <option value="prixDesc" @if($tri=="prixDesc") selected @endif>$$$-$</option>
                            </select>
                        </li>
                        <li>
                            <input class="btn btnHidden" type="submit" value="Appliquer les filtres">
                        </li>

                    </ul>

                </form>
            </div>


            <div class="catalogue__pagination">
                @include('fragments.pagination')
            </div>

            <ul class="resultats">

                @foreach($livres as $livre)
                    <li class="resultats__item">

                            <a href="{!! $urlFicheResultats . "&id=" . $livre->id !!}">

                        <ul>

                                            <li>
                                                <picture class="nom__entete">
                                                    <source srcset="{{$livre->getLink(140)}} 1x, {{$livre->getLink(300)}} 2x">
                                                    <img src="{{$livre->getLink(300)}}"
                                                         alt="Couverture du livre {{$livre->getTitre()}}"
                                                         width="140">
                                                </picture>

                                            </li>

                                            <li class="resultats__itemTitre">{{$livre->getTitre()}}</li>

                                            <li class="resultats__itemAuteur">
                                                <ul>

                                                    @foreach ($livre->getAuteurs() as $auteur)

                                                        <li>{{$auteur->getPrenomNom()}}</li>

                                                    @endforeach

                                                </ul>
                                            </li>
                                            <li class="resultats__itemPrix">{{number_format($livre->prix,2,'.', '')}}$</li>

                        </ul>
                        </a>
                    </li>
                @endforeach

            </ul>

            <div class="catalogue__pagination">
                @include('fragments.pagination')
            </div>
        </div>
    </div>
@endsection

