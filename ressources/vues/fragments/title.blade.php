@if(isset($filAriane))
    @foreach(array_reverse($filAriane) as $lien)
        @if($lien["titre"]!="Accueil") {{$lien["titre"]}} | @endif
    @endforeach
@endif Traces – Toute l’histoire des Amériques