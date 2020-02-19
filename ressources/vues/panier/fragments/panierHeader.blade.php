

    <a class="entete__menuPanier--lien" href="index.php?controleur=panier&action=index">
        <span class="soustotalHeader">{!!number_format($sousTotal,2, '.', '')!!} $ </span> | <span class="nbrItem"> {{$nbrArticles}} </span> article(s)
        <svg class="entete__menuPanier--icone">
            <use xlink:href="#panier"/>
        </svg>
    </a>




