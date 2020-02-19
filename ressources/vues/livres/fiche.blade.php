@extends('gabarit')


@section('contenu')
    <div class="vide"></div>
    <div class="livre">

        <span class="filDariane">
            @include('fragments.filAriane')

        </span>

        <div class="livre__achat">

            <div class="infoMobile">
                <h1 class="livre__achat--conteneur--titre">{{$livre->getTitre()}}</h1>
                <p class="livre__achat--conteneur--soustitre">{{$livre->sous_titre}}</p>
                <ul>
                    <li class="livre__achat--conteneur--auteur">{{$afficherAuteurs}}</li>
                    @foreach ($auteurs as $auteur)
                        @if($auteur->url_blogue != null)
                            <li class="livre__achat--conteneur--blogue"><a href="{{$auteur->url_blogue}}">Blogue de
                                    l'auteur</a></li>

                        @endif
                    @endforeach
                </ul>
            </div>

            <picture class="livre__achat--image">
                <source srcset="{{$livre->getLink(300)}} 1x, {{$livre->getLink(600)}} 2x">
                <img src="{{$livre->getLink(600)}}" alt="Couverture du livre {{$livre->getTitre()}}">
            </picture>

            <div class="livre__achat--conteneur">
                <div class="infoTable">
                    <h1 class="livre__achat--conteneur--titre">{{$livre->getTitre()}}</h1>
                    <p class="livre__achat--conteneur--soustitre">{{$livre->sous_titre}}</p>
                    <ul>
                        <li class="livre__achat--conteneur--auteur">{{$afficherAuteurs}}</li>
                        @foreach ($auteurs as $auteur)
                            @if($auteur->url_blogue != null)
                                <li class="livre__achat--conteneur--blogue"><a href="{{$auteur->url_blogue}}">Blogue de
                                        l'auteur</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>


                <div class="livre__achat--conteneur--avis">
                    <svg width="150" height="30" viewBox="0 0 150 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0003 1.12982L19.1867 9.61328L19.303 9.84901L19.5631 9.88682L28.9255 11.2476L22.1509 17.8507L21.9626 18.0342L22.0071 18.2933L23.6063 27.6179L15.233 23.2157L15.0003 23.0934L14.7676 23.2157L6.39372 27.618L7.99294 18.2933L8.03738 18.0342L7.84913 17.8507L1.0745 11.2476L10.4369 9.88682L10.697 9.84901L10.8133 9.61331L15.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M45.0003 1.12982L49.1867 9.61328L49.303 9.84901L49.5631 9.88682L58.9255 11.2476L52.1509 17.8507L51.9626 18.0342L52.0071 18.2933L53.6063 27.6179L45.233 23.2157L45.0003 23.0934L44.7676 23.2157L36.3937 27.618L37.9929 18.2933L38.0374 18.0342L37.8491 17.8507L31.0745 11.2476L40.4369 9.88682L40.697 9.84901L40.8133 9.61331L45.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M75.0003 1.12982L79.1867 9.61328L79.303 9.84901L79.5631 9.88682L88.9255 11.2476L82.1509 17.8507L81.9626 18.0342L82.0071 18.2933L83.6063 27.6179L75.233 23.2157L75.0003 23.0934L74.7676 23.2157L66.3937 27.618L67.9929 18.2933L68.0374 18.0342L67.8491 17.8507L61.0745 11.2476L70.4369 9.88682L70.697 9.84901L70.8133 9.61331L75.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M105 1.12982L109.187 9.61328L109.303 9.84901L109.563 9.88682L118.926 11.2476L112.151 17.8507L111.963 18.0342L112.007 18.2933L113.606 27.6179L105.233 23.2157L105 23.0934L104.768 23.2157L96.3937 27.618L97.9929 18.2933L98.0374 18.0342L97.8491 17.8507L91.0745 11.2476L100.437 9.88682L100.697 9.84901L100.813 9.61331L105 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M135 1.12982L139.187 9.61328L139.303 9.84901L139.563 9.88682L148.926 11.2476L142.151 17.8507L141.963 18.0342L142.007 18.2933L143.606 27.6179L135.233 23.2157L135 23.0934L134.768 23.2157L126.394 27.618L127.993 18.2933L128.037 18.0342L127.849 17.8507L121.075 11.2476L130.437 9.88682L130.697 9.84901L130.813 9.61331L135 1.12982Z"
                              fill="#F4F4F4" stroke="black"/>
                    </svg>
                    <a href="#avis">2 avis utilisateurs</a>
                </div>

                <p class="livre__achat--conteneur--prix">{{number_format($livre->prix,2,'.', '')}} $</p>

                <form action="index.php?controleur=panier&action=ajouterItem&isbn={{$livre->isbn}}&id={{$livre->id}}"
                      method="post">
                    <label class="" for="quantite">Quantité</label>
                    <select class="menuDeroulant" name="quantite" id="quantite">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                    </select>
                    <div class="livre__achat--conteneur--boutons">
                        <input class="btn livre__achat--conteneur--btnAcheter" type="submit" value="Ajouter au panier">
                        <div class="livre__achat--conteneur--favoris">
                            <a class="livre__achat--conteneur--favorisIcone" href="#">
                                <svg class="icone" viewBox="0 -28 512.00002 512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/>
                                </svg>
                                Ajouter au favoris
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($livre->description_livre != null)
            <div class="livre__resume">
                <h2>Résumé</h2>
                <p>{{$livre->getDescription()}}</p>
            </div>
        @endif


        <div class="livre__detail">
            <h2>Détail du produit</h2>
            <div class="livre__detail--conteneur">
                <ul class="livre__detail--liste1">
                    <li>
                        <p>Nombre de pages : </p>
                        <p>{{$livre->nbre_pages}} pages</p>
                    </li>
                    <li>
                        <p>Année de publication : </p>
                        <p>{{$livre->annee_publication}}</p>
                    </li>

                    <li>
                        @if($editeurs != null)
                            <p>Maison d'édition : </p><p>{{$editeurs}}</p>
                        @endif

                    </li>

                    <li>
                        @if($livre->collection_id != null)
                            <p>Collection : </p><p>{{$collection->nom_collection}}</p>
                        @endif

                    </li>
                </ul>
                <ul class="livre__detail--liste2">
                    <li>
                        @if($livre->langue === "FR")
                            <p>Langue : </p><p>Français</p>
                        @else
                            <p>Langue : </p><p>Anglais</p>

                        @endif
                    </li>
                    <li>
                        <p>Catégorie : </p>
                        <p>{{$categories}}</p>
                    </li>
                    <li>
                        <p>ISBN : </p>
                        <p>{{$livre->isbn}}</p>
                    </li>
                    <li>
                        @if($livre->autres_caracteristiques != null)
                            <p>Autres caratéristiques : </p>
                            <p>{{$livre->getCaracteristique()}}</p>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        @if($livre->getRecension() != null)
            <div class="livre__critique">
                <h2>Ce livre à fait parler de lui</h2>
                @foreach ($livre->getRecension() as $recension)
                    <div class="livre__critique--commentaire">
                        <p class="livre__critique--commentaire--date">{{$recension->getDate()}}, </p>
                        <p class="livre__critique--commentaire--journal">{{$recension->nom_media}}</p>
                        <p class="livre__critique--commentaire--citation">« {{$recension->getDescription()}} »</p>
                        @if($recension->nom_journaliste != null)
                            <p class="livre__critique--commentaire--auteur">- {{$recension->nom_journaliste}}</p>
                        @else
                            <p class="livre__critique--commentaire--auteur">- Auteur non défini</p>

                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($livre->getHonneur() != null)
            <div class="livre__honneur">
                <h2>Prix remportés</h2>

                @foreach ($livre->getHonneur() as $honneur)
                    <div class="livre__honneur--prix">
                        <p><span class="livre__honneur--titre">{{$honneur->getNom()}}</span></p>
                        @if($honneur->getNom() != $honneur->getDescription())
                            <p>{{$honneur->getDescription()}}</p>
                        @endif
                    </div>
                @endforeach


            </div>
        @endif

        <div class="livre__avis" id="avis">
            <div class="livre__avis--titre">
                <h2 class="livre__avis--titre--nom">Avis des utilisateurs</h2>
                <div class="livre__avis--titre--etoiles">
                    <svg width="100" height="20" viewBox="0 0 150 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0003 1.12982L19.1867 9.61328L19.303 9.84901L19.5631 9.88682L28.9255 11.2476L22.1509 17.8507L21.9626 18.0342L22.0071 18.2933L23.6063 27.6179L15.233 23.2157L15.0003 23.0934L14.7676 23.2157L6.39372 27.618L7.99294 18.2933L8.03738 18.0342L7.84913 17.8507L1.0745 11.2476L10.4369 9.88682L10.697 9.84901L10.8133 9.61331L15.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M45.0003 1.12982L49.1867 9.61328L49.303 9.84901L49.5631 9.88682L58.9255 11.2476L52.1509 17.8507L51.9626 18.0342L52.0071 18.2933L53.6063 27.6179L45.233 23.2157L45.0003 23.0934L44.7676 23.2157L36.3937 27.618L37.9929 18.2933L38.0374 18.0342L37.8491 17.8507L31.0745 11.2476L40.4369 9.88682L40.697 9.84901L40.8133 9.61331L45.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M75.0003 1.12982L79.1867 9.61328L79.303 9.84901L79.5631 9.88682L88.9255 11.2476L82.1509 17.8507L81.9626 18.0342L82.0071 18.2933L83.6063 27.6179L75.233 23.2157L75.0003 23.0934L74.7676 23.2157L66.3937 27.618L67.9929 18.2933L68.0374 18.0342L67.8491 17.8507L61.0745 11.2476L70.4369 9.88682L70.697 9.84901L70.8133 9.61331L75.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M105 1.12982L109.187 9.61328L109.303 9.84901L109.563 9.88682L118.926 11.2476L112.151 17.8507L111.963 18.0342L112.007 18.2933L113.606 27.6179L105.233 23.2157L105 23.0934L104.768 23.2157L96.3937 27.618L97.9929 18.2933L98.0374 18.0342L97.8491 17.8507L91.0745 11.2476L100.437 9.88682L100.697 9.84901L100.813 9.61331L105 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M135 1.12982L139.187 9.61328L139.303 9.84901L139.563 9.88682L148.926 11.2476L142.151 17.8507L141.963 18.0342L142.007 18.2933L143.606 27.6179L135.233 23.2157L135 23.0934L134.768 23.2157L126.394 27.618L127.993 18.2933L128.037 18.0342L127.849 17.8507L121.075 11.2476L130.437 9.88682L130.697 9.84901L130.813 9.61331L135 1.12982Z"
                              fill="#F4F4F4" stroke="black"/>
                    </svg>
                    <p>2 avis utilisateurs</p>
                </div>
            </div>
            <div class="livre__avis--commentaire">
                <svg class="livre__avis--commentaire--userIcon">
                    <use xlink:href="#user"/>
                </svg>
                <p class="livre__avis--commentaire--date">16/05/2015</p>
                <div class="livre__avis--commentaire--avis">
                    <h3 class="livre__avis--commentaire--titre">Bonne Lecture</h3>
                    <svg width="150" height="30" viewBox="0 0 150 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0003 1.12982L19.1867 9.61328L19.303 9.84901L19.5631 9.88682L28.9255 11.2476L22.1509 17.8507L21.9626 18.0342L22.0071 18.2933L23.6063 27.6179L15.233 23.2157L15.0003 23.0934L14.7676 23.2157L6.39372 27.618L7.99294 18.2933L8.03738 18.0342L7.84913 17.8507L1.0745 11.2476L10.4369 9.88682L10.697 9.84901L10.8133 9.61331L15.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M45.0003 1.12982L49.1867 9.61328L49.303 9.84901L49.5631 9.88682L58.9255 11.2476L52.1509 17.8507L51.9626 18.0342L52.0071 18.2933L53.6063 27.6179L45.233 23.2157L45.0003 23.0934L44.7676 23.2157L36.3937 27.618L37.9929 18.2933L38.0374 18.0342L37.8491 17.8507L31.0745 11.2476L40.4369 9.88682L40.697 9.84901L40.8133 9.61331L45.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M75.0003 1.12982L79.1867 9.61328L79.303 9.84901L79.5631 9.88682L88.9255 11.2476L82.1509 17.8507L81.9626 18.0342L82.0071 18.2933L83.6063 27.6179L75.233 23.2157L75.0003 23.0934L74.7676 23.2157L66.3937 27.618L67.9929 18.2933L68.0374 18.0342L67.8491 17.8507L61.0745 11.2476L70.4369 9.88682L70.697 9.84901L70.8133 9.61331L75.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M105 1.12982L109.187 9.61328L109.303 9.84901L109.563 9.88682L118.926 11.2476L112.151 17.8507L111.963 18.0342L112.007 18.2933L113.606 27.6179L105.233 23.2157L105 23.0934L104.768 23.2157L96.3937 27.618L97.9929 18.2933L98.0374 18.0342L97.8491 17.8507L91.0745 11.2476L100.437 9.88682L100.697 9.84901L100.813 9.61331L105 1.12982Z"
                              fill="#E6E5E5" stroke="black"/>
                        <path d="M135 1.12982L139.187 9.61328L139.303 9.84901L139.563 9.88682L148.926 11.2476L142.151 17.8507L141.963 18.0342L142.007 18.2933L143.606 27.6179L135.233 23.2157L135 23.0934L134.768 23.2157L126.394 27.618L127.993 18.2933L128.037 18.0342L127.849 17.8507L121.075 11.2476L130.437 9.88682L130.697 9.84901L130.813 9.61331L135 1.12982Z"
                              fill="#E6E5E5" stroke="black"/>
                    </svg>
                </div>
                <p class="livre__avis--commentaire--auteur">Par : Vincent Tremblay</p>
                <p class="livre__avis--commentaire--message">Heureux de l'avoir trouvé en français.</p>
            </div>
            <div class="livre__avis--commentaire">
                <svg class="livre__avis--commentaire--userIcon">
                    <use xlink:href="#user"/>
                </svg>
                <p class="livre__avis--commentaire--date">28/04/2017</p>
                <div class="livre__avis--commentaire--avis">
                    <h3 class="livre__avis--commentaire--titre">Incroyable</h3>
                    <svg width="150" height="30" viewBox="0 0 150 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.0003 1.12982L19.1867 9.61328L19.303 9.84901L19.5631 9.88682L28.9255 11.2476L22.1509 17.8507L21.9626 18.0342L22.0071 18.2933L23.6063 27.6179L15.233 23.2157L15.0003 23.0934L14.7676 23.2157L6.39372 27.618L7.99294 18.2933L8.03738 18.0342L7.84913 17.8507L1.0745 11.2476L10.4369 9.88682L10.697 9.84901L10.8133 9.61331L15.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M45.0003 1.12982L49.1867 9.61328L49.303 9.84901L49.5631 9.88682L58.9255 11.2476L52.1509 17.8507L51.9626 18.0342L52.0071 18.2933L53.6063 27.6179L45.233 23.2157L45.0003 23.0934L44.7676 23.2157L36.3937 27.618L37.9929 18.2933L38.0374 18.0342L37.8491 17.8507L31.0745 11.2476L40.4369 9.88682L40.697 9.84901L40.8133 9.61331L45.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M75.0003 1.12982L79.1867 9.61328L79.303 9.84901L79.5631 9.88682L88.9255 11.2476L82.1509 17.8507L81.9626 18.0342L82.0071 18.2933L83.6063 27.6179L75.233 23.2157L75.0003 23.0934L74.7676 23.2157L66.3937 27.618L67.9929 18.2933L68.0374 18.0342L67.8491 17.8507L61.0745 11.2476L70.4369 9.88682L70.697 9.84901L70.8133 9.61331L75.0003 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M105 1.12982L109.187 9.61328L109.303 9.84901L109.563 9.88682L118.926 11.2476L112.151 17.8507L111.963 18.0342L112.007 18.2933L113.606 27.6179L105.233 23.2157L105 23.0934L104.768 23.2157L96.3937 27.618L97.9929 18.2933L98.0374 18.0342L97.8491 17.8507L91.0745 11.2476L100.437 9.88682L100.697 9.84901L100.813 9.61331L105 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                        <path d="M135 1.12982L139.187 9.61328L139.303 9.84901L139.563 9.88682L148.926 11.2476L142.151 17.8507L141.963 18.0342L142.007 18.2933L143.606 27.6179L135.233 23.2157L135 23.0934L134.768 23.2157L126.394 27.618L127.993 18.2933L128.037 18.0342L127.849 17.8507L121.075 11.2476L130.437 9.88682L130.697 9.84901L130.813 9.61331L135 1.12982Z"
                              fill="#F9D12B" stroke="black"/>
                    </svg>
                </div>
                <p class="livre__avis--commentaire--auteur">Par : Paul Piché</p>
                <p class="livre__avis--commentaire--message">J'adore ses livres et j'ai hâte que les enfants les lisent
                    aussi. La livraison était super rapide et les livres étaient en parfait état.</p>
            </div>
            <input class="btn livre__avis--commentaire--btn" type="button" value="Écrire un avis">

        </div>

    </div>

@endsection