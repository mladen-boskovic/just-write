@extends('layouts.layout')

@section('title')
    Kontakt
@endsection

@section('sadrzaj')
    <div class="naslov_svaki">
        <p>Obratite nam se putem formulara</p>
    </div>
    <div id="contact_sadrzaj">
        <div id="contact_sadrzaj_drzac">
            <form id="forma_contact" name="forma_contact" method="POST" action="{{route('contactAdmin')}}" onSubmit="return contactProvera();">
                @csrf
                <table id="tabela_contact">
                    <tr>
                        <td>Email</td>
                    </tr>
                    <tr>
                        <td><input type="text"  value="{{old('contactEmail')}}" id="contactEmail" name="contactEmail"></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="contactEmailGreska" class="ispisGreskeContact"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Poruka</td>
                    </tr>
                    <tr>
                        <td><textarea id="poruka" name="poruka" maxlength="500">{{old('poruka')}}</textarea></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="contactPorukaGreska" class="ispisGreskeContact"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" id="contactDugme" name="contactDugme" value="POŠALJI"/></td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="contact_greske">
            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li><h5>{{$error}}</h5></li>
                    @endforeach
                </ul>
            @endif

            @if(session('uspesnaPoruka'))
                <h4>{{session('uspesnaPoruka')}}</h4>
            @endif

            @if(session('neuspesnaPoruka'))
                <h4>{{session('neuspesnaPoruka')}}</h4>
            @endif
        </div>
    </div>
@endsection