@extends('layouts.layout')

@section('title')
    {{$objava->naslov}}
@endsection

@if(!session('korisnik'))
    @if(Request::segment(3) != 0)
        <script type="text/javascript">
            window.location = "{{route('home')}}";
        </script>
    @endif
@endif

@if(session('korisnik'))
    @if(session('korisnik')->korisnikID != Request::segment(3))
        <script type="text/javascript">
            window.location = "{{route('home')}}";
        </script>
    @endif
@endif

@section('sadrzaj')
    @include('inc.jednaobjavaprikaz')
    @include('inc.jednaobjavakomentari')
@endsection