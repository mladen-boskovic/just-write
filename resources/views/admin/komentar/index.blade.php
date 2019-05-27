@extends('layouts.layout')

@section('title')
    Admin - Svi komentari
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Svi Komentari</p>
    </div>

    @if(count($komentari))
        <div class="stranice">
            {{$komentari->links()}}
        </div>

        <div id="allusers_sadrzaj">
            <table class="tabela">
                <tr>
                    <th>RB</th>
                    <th>ID</th>
                    <th>TEKST</th>
                    <th>KORISNIK</th>
                    <th>OBJAVA</th>
                    <th>DATUM POSTAVLJANJA</th>
                    <th>OBRIŠI</th>
                </tr>
                @foreach($komentari as $k)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$k->komentarID}}</td>
                        <td>{{$k->komentar}}</td>
                        <td>{{$k->korisnicko_ime}}</td>
                        <td>
                            <a href="{{route('jednaObjava', ['objavaID' => $k->objavaID, 'korisnikID' => (session('korisnik') ? session('korisnik')->korisnikID : 0)])}}">{{$k->naslov}}</a>
                        </td>
                        <td>{{date("d.m.Y H:i", $k->komentar_created_at)}}h</td>
                        <td><a href="#" data-id="{{$k->komentarID}}" class="obrisiKomentar obrisi">Obriši</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="stranice">
            {{$komentari->links()}}
        </div>
    @else
        <div class="trenutno_nema">
            <p>Trenutno nema komentara</p>
        </div>
    @endif
@endsection