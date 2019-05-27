<div id="footer">
    <ul>
        @foreach($meni as $m)
            @if(session('korisnik') and ($m->meni == "PRIJAVI SE" or $m->meni == "REGISTRACIJA"))
                @continue
            @endif

            @if(!session('korisnik') and ($m->meni == "ODJAVI SE" or $m->meni == "PROFIL" or $m->meni == "DODAJ OBJAVU"))
                @continue
            @endif

            @if($m->meni == "PROFIL")
                <li><a href="{{url('/') . $m->putanja . (session('korisnik') ? session('korisnik')->korisnikID : 0)}}">{{$m->meni}}</a>
            @else
                <li><a href="{{url('/') . $m->putanja}}">{{$m->meni}}</a>
            @endif
        @endforeach
    </ul>
    <p>Copyright &copy; Just Write...</p>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('js/simpleLightbox.min.js')}}"></script>