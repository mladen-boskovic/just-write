@isset($children)
    @if(count($children) > 0)
        <ul>
            @foreach($children as $child)
                @if(session('korisnik') and ($child->meni == "PRIJAVI SE" or $child->meni == "REGISTRACIJA"))
                    @continue
                @endif

                @if(!session('korisnik') and ($child->meni == "ODJAVI SE" or $child->meni == "PROFIL" or $child->meni == "DODAJ OBJAVU"))
                    @continue
                @endif

                @if($child->meni == "PROFIL")
                    <li><a href="{{url('/') . $child->putanja . (session('korisnik') ? session('korisnik')->korisnikID : 0)}}">{{$child->meni}}</a>
                        @foreach($meni as $m)
                            @if($m->meniID == $child->meniID)
                                @component('components.meni', [
                                    'children' => $m->submenus,
                                    'meni' => $meni
                                ])
                                @endcomponent
                            @endif
                        @endforeach
                    </li>
                @else
                    <li><a href="{{url('/') . $child->putanja}}">{{$child->meni}}</a>
                        @foreach($meni as $m)
                            @if($m->meniID == $child->meniID)
                                @component('components.meni', [
                                    'children' => $m->submenus,
                                    'meni' => $meni
                                ])
                                @endcomponent
                            @endif
                        @endforeach
                    </li>
                @endif

            @endforeach
        </ul>
    @endif
@endisset