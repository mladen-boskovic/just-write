@extends('layouts.layout')

@section('title')
    Profil
@endsection

@if(session('korisnik')->korisnikID != Request::segment(2))
    <script type="text/javascript">
        window.location = "{{route('home')}}";
    </script>
@endif

@section('sadrzaj')
    @include('inc.userinfopassword')
    @include('inc.userpersonaldata')
@endsection