@extends('layouts.layout')

@section('title')
    Autor
@endsection

@section('sadrzaj')
    <div class="naslov_svaki">
        <p>O Autoru</p>
    </div>
    <div id="author_sadrzaj">
        <div id="author_drzac">
            <a href="{{asset('images/autor.jpg')}}" class="vecaSlika">
                <img src="{{asset('images/autor.jpg')}}" alt="Autor"/>
            </a>
            <div id="author_tekst">
                Zovem se Mladen Bošković. Rođen sam u Kruševcu 1995. godine, gde sam završio osnovnu i srednju školu. Studiram na Visokoj ICT školi, smer Internet tehnologije.
            </div>
        </div>
        <div id="dokumentacija">
            <a href="{{asset('/dokumentacija.pdf')}}" target="_blank">Dokumentacija &nbsp;<i class="fas fa-file-pdf"></i></a>
        </div>
    </div>
@endsection