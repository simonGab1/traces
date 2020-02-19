

    <!-- Si on est pas sur la première page et s'il y a plus d'une page -->
    @if ($numeroPage > 0)

            <a class="fleche fleche--left fleche--leftDouble" href= "{!! $urlLivresResultats . "&page=" . 0  !!}"></a>


    @else
        <span class="fleche fleche--left fleche--leftDouble" style="opacity:0.4;"></span> <!-- Bouton premier inactif -->
    @endif

    @if ($numeroPage > 0)

            <a class="fleche fleche--left" href="{!! $urlLivresResultats . "&page=" . (htmlspecialchars($numeroPage) - 1) !!}"></a>

    @else
        <span class="fleche fleche--left" style="opacity:0.4;"></span><!-- Bouton précédent inactif -->
    @endif


    <!-- Statut de progression: page 9 de 99 -->
{{--    {{"Page " . ($numeroPage + 1) . " de " . ($nombreTotalPages + 1)}}--}}
    {{($numeroPage + 1)}}

    <!-- Si on est pas sur la dernière page et s'il y a plus d'une page -->
    @if ($numeroPage < $nombreTotalPages)

            <a class="fleche fleche--right" href="{!! $urlLivresResultats . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}"></a>


    @else
        <span class="fleche fleche--right" style="opacity:0.4;"></span><!-- Bouton suivant inactif -->
    @endif


    @if ($numeroPage < $nombreTotalPages)

            <a class="fleche fleche--right fleche--rightDouble" href="{!! $urlLivresResultats . "&page=" . htmlspecialchars($nombreTotalPages) !!}"></a>


    @else
        <span class="fleche fleche--right fleche--rightDouble" style="opacity:0.4;"></span><!-- Bouton dernier inactif -->
    @endif



