<div class="entete onlyTable">
    <ul class="entete__utilisateur">
        <li class="entete__utilisateur--lien">
            @if(!$idClient)
                <a href="index.php?controleur=compte&action=connexion">
                    <svg class="entete__utilisateur--icone">
                        <use xlink:href="#connexion"/>
                    </svg>
                    <span>Se connecter</span>
                </a>
            @else
                <a href="index.php?controleur=compte&action=deconnexion">
                    <svg class="entete__utilisateur--icone">
                        <use xlink:href="#deconnexion"/>
                    </svg>
                    <span>Se deconnecter</span>
                </a>
            @endif
        </li>
        <li class="entete__utilisateur--lien">
            <a href="#">
                <svg class="entete__utilisateur--icone">
                    <use xlink:href="#compte"/>
                </svg>
                <span>Mon compte</span>
            </a>
        </li>
        <li class="entete__utilisateur--lien"><a href="#">English</a></li>
    </ul>

    <div class="entete__recherche" role=”search”>

        <a href="index.php?controleur=site&action=accueil" class="entete__recherche--logo"></a>

        <form class="entete__recherche--form">
            <select class="menuDeroulant menuDeroulant__entete selectBlanc" name="critere" id="critere">
                <option value="sujet">Sujet</option>
                <option value="auteur">Auteur</option>
                <option value="titre">Titre</option>
                <option value="isbn">ISBN</option>
            </select>

                <input class="inputBlanc inputRecherche" name="mot_cle" id="mot_cle" type="search">
                <div id="rechercheResultats" class="rechercheResultats"></div>

            <input class="btn" type="submit" value="Recherche">

        </form>
    </div>

    <nav aria-label=”Navigation-principale” class="entete__menuPanier">
        <ul class="entete__menu">
            <li class="entete__menu--lien">
                @if($nomPage == "Livres")
                    <span class="entete__menu--lienActif">Livres</span>
                @else
                <a href="index.php?controleur=livre&action=index">Livres</a>
            @endif
            </li>
            <li class="entete__menu--lien"><a href="#">Meilleurs vendeurs</a></li>
            <li class="entete__menu--lien"><a href="#">Découvrir Traces</a></li>
            <li class="entete__menu--lien"><a href="#">Auteurs</a></li>
            <li class="entete__menu--lien"><a href="#">Nous joindre</a></li>
        </ul>
        <div class="entete__menuPanier--background">
            @include("panier.fragments.panierHeader")
            @include("panier.fragments.recapitulatif")
        </div>
    </nav>
</div>

