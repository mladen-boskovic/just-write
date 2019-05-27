@extends('layouts.layout')

@section('title')
    Admin Početna
@endsection

@section('sadrzaj')
    <div id="admin_meni">
        <h1>Admin Meni</h1>
    </div>

    <div id="admin_sadrzaj">
        <div id="admin_drzac">
            <ul>
                <li>
                    <a href="{{route('objava.index')}}">SVE OBJAVE</a>
                </li>
                <li>
                    <a href="{{route('objava.create')}}">DODAJ OBJAVU</a>
                </li>
                <br/>
                <li>
                    <a href="{{route('korisnik.index')}}">SVI KORISNICI</a>
                </li>
                <li>
                    <a href="{{route('korisnik.create')}}">DODAJ KORISNIKA</a>
                </li>
                <br/>
                <li>
                    <a href="{{route('kategorija.index')}}">SVE KATEGORIJE</a>
                </li>
                <li>
                    <a href="{{route('kategorija.create')}}">DODAJ KATEGORIJU</a>
                </li>
                <br/>
                <li>
                    <a href="{{route('komentar.index')}}">SVI KOMENTARI</a>
                </li>
                <br/>
                <li>
                    <a href="{{route('aktivnost.index')}}">SVE AKTIVNOSTI</a>
                </li>
            </ul>
        </div>
    </div>
@endsection