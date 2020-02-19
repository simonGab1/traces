@foreach ($items as $livres)
    <div class="panier__article panier__article-{{$livres->livre->id}}">
        <picture class="panier__article--image">
            <source srcset="{{$livres->livre->getLink(70)}} 1x, {{$livres->livre->getLink(140)}} 2x"
                    media="(max-width: 800px)">
            <source srcset="{{$livres->livre->getLink(140)}} 1x, {{$livres->livre->getLink(300)}} 2x"
                    media="(min-width: 801px)">
            <img src="{{$livres->livre->getLink(140)}}" alt="Couverture du livre {{$livres->livre->getTitre()}}">
        </picture>
        <div class="panier--mobile">
            <div class="panier__article--infos">
                <p class="panier__article--infos--titre">{{$livres->livre->getTitre()}}</p>
                <p class="panier__article--infos--soustitre">{{$livres->livre->sous_titre}}</p>
                @foreach($livres->livre->getAuteurs() as $auteur)
                    <p class="panier__article--infos--auteur">{{$auteur->getPrenomNom()}}</p>
                @endforeach
                <p class="panier__article--infos--prix">{{ number_format($livres->livre->prix, 2, '.', '')}}
                    $</p>
            </div>

            <form class="panier__article--form"
                  action="index.php?controleur=panier&action=majQte&isbn={{$livres->livre->isbn}}" method="post">
                <div class="panier__article--quantite">
                    <label for="nouvelleQuantite">Quantité</label>
                    <select class="inputGeneral menuDeroulant ajaxQte" name="nouvelleQuantite" id="{{$livres->livre->isbn}}">
                        <option value="01" @if($livres->quantite === 1) selected @endif>01</option>
                        <option value="02" @if($livres->quantite === 2) selected @endif>02</option>
                        <option value="03" @if($livres->quantite === 3) selected @endif>03</option>
                        <option value="04" @if($livres->quantite === 4) selected @endif>04</option>
                        <option value="05" @if($livres->quantite === 5) selected @endif>05</option>
                        <option value="06" @if($livres->quantite === 6) selected @endif>06</option>
                        <option value="07" @if($livres->quantite === 7) selected @endif>07</option>
                        <option value="08" @if($livres->quantite === 8) selected @endif>08</option>
                        <option value="09" @if($livres->quantite === 9) selected @endif>09</option>
                        <option value="10" @if($livres->quantite === 10) selected @endif>10</option>
                    </select>
                    <input type="hidden" id="isbn" value="{{$livres->livre->isbn}}">
                    <input type="hidden" id="id" value="{{$livres->livre->id}}">

                </div>
                <input type="hidden" name="pageActive" value="{{$pageActive}}">
                <input class="btn btnHidden" type="submit" value="Mettre a jour le panier" id="qte-{{$livres->livre->id}}">
            </form>

            <form class="panier__article--retirer"
                  action="index.php?controleur=panier&action=supprimerItem&isbn={{$livres->livre->isbn}}" method="post">
                <input class="panier__article--retirer--btn" type="submit" value="Retirer du panier">
            </form>

            <div class="panier__article--prix">
                <p class="panier__article--prix--total">Total</p>
                <p class="soustotalArticle-{{$livres->livre->isbn}}"> {{ number_format($livres->livre->prix * $livres->quantite, 2, '.', '')}}
                    $</p>
            </div>
        </div>
    </div>
@endforeach


