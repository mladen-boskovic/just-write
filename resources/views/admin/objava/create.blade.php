@extends('layouts.layout')

@section('title')
    Admin - Dodavanje objave
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Dodajte Objavu</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_addObjava" name="forma_addObjava" method="POST" action="{{route('objava.store')}}" onSubmit="return addObjavaProvera();" enctype="multipart/form-data">
                @csrf
                <table id="tabela_addObjava">
                    <tr>
                        <td colspan="2">Naslov</td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea id="addObjavaNaslov" name="addObjavaNaslov" maxlength="100">{{old('addObjavaNaslov')}}</textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="addObjavaNaslovGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Tekst</td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea id="addObjavaTekst" name="addObjavaTekst" maxlength="1000">{{old('addObjavaTekst')}}</textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="addObjavaTekstGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Kategorija</td>
                        <td>Slika</td>
                    </tr>
                    <tr>
                        <td>
                            <select id="addObjavaKategorija" name="addObjavaKategorija">
                                <option value="0">Izaberite</option>
                                @foreach($kategorije as $k)
                                    <option value="{{$k->kategorijaID}}">{{$k->kategorija}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="file" id="addObjavaSlika" name="addObjavaSlika"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="addObjavaKategorijaGreska" class="ispisGreske"></div>
                        </td>
                        <td>
                            <div id="addObjavaSlikaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" id="addObjavaDugme" name="addObjavaDugme" value="DODAJ OBJAVU" class="inputi_dugme"/>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="addObjavaKorisnikID" name="addObjavaKorisnikID" value="{{session('korisnik')->korisnikID}}"/>
            </form>
        </div>
    </div>


    @include('inc.greskelevo')

@endsection