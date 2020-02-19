<div class="entete onlyMobile">

    <nav aria-label=”Navigation-principale” class="entete__menuPanier">
        <a class="icon">
            <svg id="hamburger" class="entete__menuPanier--icone">
                <use xlink:href="#menu"/>
            </svg>
            <svg id="fermer" class="entete__menuPanier--icone visuallyhidden">
                <use xlink:href="#menuFermer"/>
            </svg>
        </a>

        <a href="index.php?controleur=site&action=accueil" class="entete__menuPanier--logo"></a>

        <div class="entete__menuPanier--iconePanier">
            @include("panier.fragments.panierHeaderMobile")
        </div>
    </nav>
    <div>
        <div id="myLinks">
            <form class="entete__recherche--form">
                <select class="menuDeroulant menuDeroulant__entete" name="critereMobile" id="critereMobile">
                    <option value="sujet">Sujet</option>
                    <option value="auteur">Auteur</option>
                    <option value="titre">Titre</option>
                    <option value="isbn">ISBN</option>
                </select>
                <input class="inputBlanc inputRecherche" name="mot_cleMobile" id="mot_cleMobile" type="search">
                <div id="rechercheResultatsMobile" class="rechercheResultats rechercheResultats--mobile"></div>
            </form>
            <ul class="entete__utilisateur">
                <li class="entete__utilisateur--lien">
                    @if(!$idClient)
                        <a href="index.php?controleur=compte&action=connexion">
                            <svg class="entete__utilisateur--icone">
                                <use xlink:href="#connexionMobile"/>
                            </svg>
                            <span>Se connecter</span>
                        </a>
                    @else
                        <a href="index.php?controleur=compte&action=deconnexion">
                            <svg class="entete__utilisateur--icone">
                                <use xlink:href="#deconexionMobile"/>
                            </svg>
                            <span>Se deconnecter</span>
                        </a>
                    @endif
                </li>
                <li class="entete__utilisateur--lien">
                    <a href="#">
                        <svg class="entete__utilisateur--icone">
                            <use xlink:href="#compteMobile"/>
                        </svg>
                        <span>Mon compte</span>
                    </a>
                </li>

            </ul>
            <hr>
            <div class="topnav">
                <a href="index.php?controleur=livre&action=index">Livres</a>
                <a href="#">Meilleurs vendeurs</a>
                <a href="#">Découvrir Traces</a>
                <a href="#">Auteurs</a>
                <a href="#">Nous joindre</a>
                <hr>
                <a href="#" class="english">English</a>
            </div>

        </div>
    </div>
    @include("panier.fragments.recapitulatif")

</div>

