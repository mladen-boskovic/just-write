@extends('layouts.layout')

@section('title')
    Admin - Svi korisnici
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Svi Korisnici</p>
    </div>

    @if(count($korisnici))
        <div class="stranice">
            {{$korisnici->links()}}
        </div>

        <div id="allusers_sadrzaj">
            <table class="tabela">
                <tr>
                    <th>RB</th>
                    <th>ID</th>
                    <th>SLIKA</th>
                    <th>IME</th>
                    <th>PREZIME</th>
                    <th>EMAIL</th>
                    <th>KORISNIČKO IME</th>
                    <th>ULOGA</th>
                    <th>AKTIVAN</th>
                    <th>DATUM REGISTRACIJE</th>
                    <th>IZMENI</th>
                    <th>OBRIŠI</th>
                </tr>
                @foreach($korisnici as $k)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$k->korisnikID}}</td>
                        <td>
                            <img src="{{asset('images/profile/' . $k->src)}}" alt="{{$k->alt}}" class="allUsersSlika"/>
                        </td>
                        <td>{{$k->ime}}</td>
                        <td>{{$k->prezime}}</td>
                        <td>{{$k->email}}</td>
                        <td>{{$k->korisnicko_ime}}</td>
                        <td>{{$k->uloga}}</td>
                        <td>{{$k->aktivan == 0 ? "Ne" : "Da"}}</td>
                        <td>{{date("d.m.Y H:i", $k->datum_registracije)}}h</td>
                        <td><a href="{{route('korisnik.edit', ['id' => $k->korisnikID])}}" class="detaljnijeD">Izmeni</a></td>
                        <td><a href="#" data-id="{{$k->korisnikID}}" class="obrisiKorisnika obrisi">Obriši</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="stranice">
            {{$korisnici->links()}}
        </div>
    @else
        <div class="trenutno_nema">
            <p>Trenutno nema korisnika</p>
        </div>
    @endif
@endsection