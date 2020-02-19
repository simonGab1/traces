@extends('gabarit')

@section('contenu')
    <div class="cc__conteneur">
        <h2 class="accueil__h2">Coup de coeur</h2>
        <div class="cc">
            <picture>
                <source srcset="liaisons/images/couvertures/L97828944848901_w300.jpg 1x, liaisons/images/couvertures/L97828944848901_w600.jpg 2x"
                        media="(min-width: 600px)">
                <img src="liaisons/images/couvertures/L97828944848901_w300.jpg" />
            </picture>
            <div class="cc__bloc">
                <h3 class="cc__titre">Dictionnaire Mondial des images</h3>
                <p class="cc__auteur">Laurent Genevreau</p>
                <p class="cc__critique">La critique des médias</p>
                <p class="cc__texte">Tout fait image. L'image fait tout. Et plus encore avec le Net. Reste à décrypter. Laurent Gervereau propose l'arme absolue.</p>
                <p class="cc__texte">Président de l'Institut des images, Laurent Gervereau se consacre depuis vingt-cinq ans au décryptage du visuel et de tous les types d'images :
                    les voir, les comprendre, les analyser. Ce qui le place à l'intersection de nombreuses disciplines, entre la sociologie de la communication,
                    l'histoire de l'art et la "médiologie".[...]</p>
                <div class="lien cc__lien">
                    <a class="btnCoupCoeur" href="index.php?controleur=livre&action=fiche&id=2640">En savoir plus sur ce livre <span class="screen-reader-only">Dictionnaire Mondial des images</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="nouveaute__titre flex_titre">
        <h2 class="accueil__h2">Nouveautés</h2>
        <div class="lien">
            <a class="lien__titre" href="{!! $urlAction . "index&nouveautes=nouveautes" !!}">Toutes les nouveautés</a>
        </div>
    </div>
    <div class="background_nouveaute">
        <div class="n conteneur">
            <div  id="nouveaute_left">
                <img src="liaisons/images/svg/nouveaute_gauche.svg" alt="">
            </div>
            @foreach($livres as $livre)

                <div class="n__livre">
                    <form action="index.php?controleur=panier&action=ajouterItem&isbn={{$livre->isbn}}&id={{$livre->id}}" method="post">
                        <input type="hidden" name="quantite" id="quantite" value="1">
                        <input type="hidden" name="accueil" id="accueil" value="true">
                    <a class="n__lien" href="{!! $urlAction . "fiche&id=" . $livre->id ."&nouveautes=nouveautes"!!}">
                        <picture>
                            <source srcset="{{$livre->getLink(300)}} 1x, {{$livre->getLink(600)}} 2x" media="(min-width: 601px)">
                            <source srcset="{{$livre->getLink(220)}} 1x, {{$livre->getLink(440)}} 2x" media="(max-width: 600px)">
                            <img src="{{$livre->getLink(300)}}"
                                 alt="Couverture du livre {{$livre->getTitre()}}">
                        </picture>
                    <h3 class="n__titre">{{$livre->getTitre()}} et {{$livre->isbn}} et{{$livre->id}}</h3>
                    </a>

                    @foreach ($livre->getAuteurs() as $auteur)
                        <h4 class="n__auteur">{{ $auteur->getPrenomNom() }}</h4>
                    @endforeach
                    <div class="n__prix">
                        <img class="n__icon" src="liaisons/images/svg/prixLivre.svg" alt="prix format papier"/>
                        <span>{{$livre->prix}} $</span>
                    </div>
                    <button class="btn" type="submit">Ajouter au panier</button>
                    </form>
                </div>
            @endforeach
            <div  id="nouveaute_right">
                <img src="liaisons/images/svg/nouveaute_droite.svg" alt="">
            </div>
        </div>
    </div>
    <div class="flex_titre actualite__titre">
        <h2 class="accueil__h2">Actualités littéraires</h2>
        <div class="lien">
            <a class="lien__titre" href="">Toutes les actualités</a>
            <span class="lien__icon"></span>
        </div>
    </div>
    @foreach ($actualites as $actualite)
        <div class="al">
            <picture class="blocA">
                <source srcset="liaisons/images/actualites/{{$actualite->id}}_w360.jpg 1x, liaisons/images/actualites/{{$actualite->id}}_w720.jpg 2x" media="(min-width: 601px)">
                <source srcset="liaisons/images/actualites/{{$actualite->id}}_w320.jpg 1x, liaisons/images/actualites/{{$actualite->id}}_w640.jpg 2x" media="(max-width: 600px)">
                <img src="liaisons/images/actualites/{{$actualite->id}}_w320.jpg" />
            </picture>
            <div class="blocB">
                <span class="al__date">{{$actualite->dateComplete()}}</span>
                <h3 class="al__titre">{{$actualite->titre_actualite}}</h3>
                @foreach ($actualite->getAuteurs() as $auteur)
                    <h4 class="al__auteur">{{ $auteur->getPrenomNom() }}</h4>
                @endforeach
            </div>
            <div class="blocC">
                <p class="al__texte">{{$actualite->texteSansBalisesCoupe()}}</p>
                <div class="lien ">
                    <a class="btnLien" href="">Lire la suite de l'article <span class="screen-reader-only"> {{$actualite->titre_actualite}} </span></a>
                </div>
            </div>
        </div>
    @endforeach
@endsection

