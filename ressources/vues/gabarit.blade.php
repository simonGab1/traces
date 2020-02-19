<!DOCTYPE html>
<html lang="fr">
<head>
    <title>
        @include('fragments.title')
    </title>
    <link rel="stylesheet" type="text/css" href="./liaisons/css/styles.css">
    <link rel="stylesheet" href="./liaisons/css/styles.css" type="text/css" media="print" />
    <link rel="icon" href="liaisons/images/favicon.png" sizes="32x32" />
    <meta charset="utf-8">

    @if($nomPage == "Fiche")
        <meta name="keywords" content="{{$livre->mots_cles}}">
        <meta name="description" content="{{$livre->getDescription()}}">
    @else
        <meta name="keywords" content="Livres, Histoires, Références, Traces, Librairie">
        <meta name="description"
              content="Traces, éditeur et libraire - La référence en livres d’histoires du Québec, du Canada et de l’Amérique du Nord">
    @endif

    <meta name="author" content="Alexandre Blanchet, Andréa Deshaies et Simon-Gabriel Côté Poulin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable">Aller au contenu</a>
<header role=”banner” id="sectionEntete">


    @include('fragments.entete')
    @include('fragments.enteteMobile')


</header>

<main class="conteneur" id="contenu">
    <a href="#sectionEntete" id="btn__RetourHaut" class="focusable"><span
                class="visuallyhidden">Retourner au menu</span></a>
    @yield('contenu')
</main>

<footer>
    @include('fragments.pieddepage')
</footer>


<!-- On importe toutes les classes de l'application et on instancie l'application dans app.js. -->
<script src="liaisons/js/objMessages.js"></script>
<script src="../node_modules/requirejs/require.js" data-main="liaisons/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<div class="visuallyhidden">
    <?php echo file_get_contents("../public/liaisons/symbol/svg/sprite.symbol.svg"); ?>
</div>


</body>
</html>




