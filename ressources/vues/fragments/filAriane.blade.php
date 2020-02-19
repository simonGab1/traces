
<span class="catalogue__filDariane onlyTable">
@foreach($filAriane as $lien)
    @if(isset($lien["lien"]))
        <a href="{{$lien["lien"]}}">{{$lien["titre"]}}</a>
        <span> / </span>
    @else
        {{$lien["titre"]}}
    @endif

@endforeach
</span>

<span class="catalogue__filDariane onlyMobile">
    <span class="fleche fleche--left"></span><a href="{{$filAriane[count($filAriane)-2]["lien"]}}" >{{$filAriane[count($filAriane)-2]["titre"]}}</a>
</span>

