@if(isset($message) AND $message != "")
    <div class="entete__retroaction">
        <div class="entete__retroaction--triangle"></div>
        <div class="entete__retroaction--message">
            <svg class="entete__retroaction--icone">
                <use xlink:href="#success"/>
            </svg>
            <div>
                <span class="entete__retroaction--message--titre">{{$message}} </span>
                <br>
                <span> à été ajouté au panier</span>
            </div>
        </div>

    </div>
@endif



