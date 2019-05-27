@extends('layouts.layout')

@section('title')
    Admin - Sve objave
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Sve Objave</p>
    </div>

    @if(count($objave))
        <div class="stranice">
            {{$objave->links()}}
        </div>

        <div id="allusers_sadrzaj">
            <table class="tabela">
                <tr>
                    <th>RB</th>
                    <th>ID</th>
                    <th>SLIKA</th>
                    <th>NASLOV</th>
                    <th>TEKST</th>
                    <th>DATUM POSTAVLJANJA</th>
                    <th>DATUM POSLEDNJE IZMENE</th>
                    <th>KORISNIK</th>
                    <th>KATEGORIJA</th>
                    <th>IZMENI</th>
                    <th>OBRIŠI</th>
                </tr>
                @foreach($objave as $o)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$o->objavaID}}</td>
                        <td>
                            <img src="{{asset('images/objave/' . $o->src)}}" alt="{{$o->alt}}" class="allUsersSlika"/>
                        </td>
                        <td>
                            <a href="{{route('jednaObjava', ['objavaID' => $o->objavaID, 'korisnikID' => (session('korisnik') ? session('korisnik')->korisnikID : 0)])}}">{{$o->naslov}}</a>
                        </td>
                        <td>{{$o->tekst}}</td>
                        <td>{{date("d.m.Y H:i", $o->objava_created_at)}}h</td>
                        <td>{{date("d.m.Y H:i", $o->objava_updated_at)}}h</td>
                        <td>{{$o->korisnicko_ime}}</td>
                        <td>{{$o->kategorija}}</td>
                        <td><a href="{{route('objava.edit', ['id' => $o->objavaID])}}" class="detaljnijeD">Izmeni</a></td>
                        <td><a href="#" data-id="{{$o->objavaID}}" class="obrisiObjavu obrisi">Obriši</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="stranice">
            {{$objave->links()}}
        </div>
    @else
        <div class="trenutno_nema">
            <p>Trenutno nema objava</p>
        </div>
    @endif
@endsection