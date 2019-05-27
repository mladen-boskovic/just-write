@extends('layouts.layout')

@section('title')
    Admin - Sve kategorije
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Sve Kategorije</p>
    </div>

    @if(count($kategorije))
        <div id="allusers_sadrzaj">
            <table class="tabela">
                <tr>
                    <th>RB</th>
                    <th>ID</th>
                    <th>NAZIV</th>
                    <th>IZMENI</th>
                    <th>OBRIŠI</th>
                </tr>
                @foreach($kategorije as $k)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$k->kategorijaID}}</td>
                        <td>{{$k->kategorija}}</td>
                        <td><a href="{{route('kategorija.edit', ['id' => $k->kategorijaID])}}" class="detaljnijeD">Izmeni</a></td>
                        <td><a href="#" data-id="{{$k->kategorijaID}}" class="obrisiKategoriju obrisi">Obriši</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="trenutno_nema">
            <p>Trenutno nema kategorija</p>
        </div>
    @endif
@endsection