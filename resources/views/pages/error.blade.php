@extends('layouts.layout')

@section('title')
    Greška
@endsection

@section('sadrzaj')
    @if(session('uspesnaPoruka'))
        <div class="errors_uspesno">
            <h2>{{session('uspesnaPoruka')}}</h2>
        </div>
    @endif

    @if(session('neuspesnaPoruka'))
        <div class="errors_neuspesno">
            <h2>{{session('neuspesnaPoruka')}}</h2>
        </div>
    @endif
@endsection