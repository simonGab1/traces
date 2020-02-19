

<div class="navTransaction">
    <ul class="navTransaction__liste">

        @if($nomPage === "Livraison")
            <li class="navTransaction__item navTransaction__item--actif"  >Livraison</li>
        @else
            <a class="navTransaction__item navTransaction__item--passee" href="index.php?controleur=livraison&action=livraison"><li >Livraison</li></a>

        @endif

        @if($nomPage === "Facturation")
        <li class="navTransaction__item navTransaction__item--actif">Facturation</li>
            @else
                @if($nomPage === "Livraison")
                    <li class="navTransaction__item navTransaction__item--inactif">Facturation</li>
                @else
                    <a class="navTransaction__item navTransaction__item--passee" href="index.php?controleur=facturation&action=facturation"><li >Facturation</li></a>
                @endif
            @endif

            @if($nomPage === "Validation")
        <li class="navTransaction__item navTransaction__item--actif">Validation</li>
            @else
                @if($nomPage === "Livraison" || $nomPage === "Facturation")
                    <li class="navTransaction__item navTransaction__item--inactif">Validation</li>
                @else
                    <a class="navTransaction__item navTransaction__item--passee" href="index.php?controleur=validation&action=validation"><li >Validation</li></a>
                @endif
            @endif
    </ul>
</div>