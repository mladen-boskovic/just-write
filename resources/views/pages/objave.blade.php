@extends('layouts.layout')

@section('title')
    Sve objave
@endsection

@section('sadrzaj')

<div class="naslov_svaki">
    <p>Sve objave</p>
</div>

<div id="searchDiv">
    <p>
        <input type="text" id="searchInput" name="searchInput" class="inputi"/>
        <input type="button" id="searchButton" name="searchButton" value="PRETRAŽI"/>
    </p>
</div>

<input type="hidden" id="objavepageKorisnikID" name="objavepageKorisnikID" value="@if(session('korisnik')){{session('korisnik')->korisnikID}}@endif"/>

<div class="straniceAjax">
</div>

<div id="objave_sadrzaj">
    <div id="objave_drzac">
        <div id="filter_sort">
            <h5>Filtriranje i sortiranje</h5>

            <div>
                <p>Sortiraj :</p>
                <select id="sortiraj">
                    <option value="0">Izaberite</option>
                    <option value="1">Najnovije</option>
                    <option value="2">Najstarije</option>
                    <option value="3">Naslov A-Z</option>
                    <option value="4">Naslov Z-A</option>
                </select>
            </div>

            <div>
                <p>Kategorija :</p>
                @if(count($kategorije))
                    @foreach($kategorije as $k)
                        <input type="checkbox" name="kategorija_filter" class="kategorija_filter" value="{{$k->kategorijaID}}"/> {{$k->kategorija}} <br/>
                    @endforeach
                @else
                    Nema kategorija
                @endif
            </div>
        </div>

        <div id="objave_objavepage">
        </div>

    </div>
</div>

<div class="straniceAjax">
</div>

<div class="ucitavanje">
</div>

@endsection