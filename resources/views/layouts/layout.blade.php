<!DOCTYPE html>
<html lang="sr">
<script type="text/javascript">
    var baseUrl = "{{url('/')}}";
</script>
@include('common.head')
<body>

<div id="navigacija">
    <div id="nav">
        <div id="logo">
            <a href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" alt="Logo"/></a>
        </div>

        <ul>
            @foreach($meni as $m)
                @if(session('korisnik') and ($m->meni == "PRIJAVI SE" or $m->meni == "REGISTRACIJA"))
                    @continue
                @endif

                @if(!session('korisnik') and ($m->meni == "ODJAVI SE" or $m->meni == "PROFIL" or $m->meni == "DODAJ OBJAVU"))
                    @continue
                @endif

                @if($m->meni == "PROFIL")
                    @if($m->roditeljID == 0)
                        <li><a href="{{url('/') . $m->putanja . (session('korisnik') ? session('korisnik')->korisnikID : 0)}}">{{$m->meni}}</a>
                            @component('components.meni', [
                                'children' => $m->submenus,
                                'meni' => $meni
                            ])
                            @endcomponent
                        </li>
                    @endif
                @else
                    @if($m->roditeljID == 0)
                        <li><a href="{{url('/') . $m->putanja}}">{{$m->meni}}</a>
                            @component('components.meni', [
                                'children' => $m->submenus,
                                'meni' => $meni
                            ])
                            @endcomponent
                        </li>
                    @endif
                @endif

            @endforeach
        </ul>
    </div>
    @if(session('korisnik'))
        @if(session('korisnik')->uloga == "Admin")
            <a href="{{route('adminhomepage')}}" id="adminLink">ADMIN PANEL</a>
        @endif
    @endif
</div>

@yield('sadrzaj')

@include('common.footer')

</body>
</html>