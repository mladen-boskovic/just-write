@extends('layouts.layout')

@section('title')
    Stranica nije pronađena
@endsection

@section('sadrzaj')
    <div id="error404">
        <p>Stranica nije pronađena</p>
        <img src="{{asset('images/404.jpg')}}" alt="Stranica nije pronađena"/>
    </div>
@endsection