@foreach ($sessionPanier as $livres)
    <div class="confirmationPanier confirmationPanier__flex">
        <picture>
            <source srcset="{{$livres->livre->getLink(70)}} 1x, {{$livres->livre->getLink(140)}} 2x"
                    media="(max-width: 800px)">
            <source srcset="{{$livres->livre->getLink(140)}} 1x, {{$livres->livre->getLink(300)}} 2x"
                    media="(min-width: 801px)">
            <img src="{{$livres->livre->getLink(140)}}" alt="Couverture du livre {{$livres->livre->getTitre()}}">
        </picture>
        <div class="confirmationPanier__contenu">
            <h3 class="confirmationPanier__titre">{{$livres->titre_livre}}</h3>
            <h4 class="confirmationPanier__titre">{{$livres->livre->sous_titre}}</h4>
            @foreach($livres->livre->getAuteurs() as $auteur)
                <p class="confirmationPanier__sous">{{$auteur->getPrenomNom()}}</p>
            @endforeach
            <p class="confirmationPanier__prix">{{ number_format($livres->livre->prix, 2, '.', '')}}
                $</p>
        </div>
    </div>
@endforeach
