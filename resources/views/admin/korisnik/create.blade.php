@extends('layouts.layout')

@section('title')
    Admin - Dodavanje korisnika
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Dodajte Korisnika</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_register" name="forma_register" method="POST" action="{{route('korisnik.store')}}" onSubmit="return addUserProvera();" enctype="multipart/form-data">
                @csrf
                <table id="tabela_adduser">
                    <tr>
                        <td>Ime</td>
                        <td>Prezime</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="regIme" name="regIme" value="{{old('regIme')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                        <td><input type="text" id="regPrezime" name="regPrezime" value="{{old('regPrezime')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="regImeGreska" class="ispisGreske"></div>
                        </td>
                        <td>
                            <div id="regPrezimeGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>Korisničko ime</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="regEmail" name="regEmail" value="{{old('regEmail')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                        <td><input type="text" id="regKorIme" name="regKorIme" value="{{old('regKorIme')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="regEmailGreska" class="ispisGreske"></div>
                        </td>
                        <td>
                            <div id="regKorImeGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Lozinka</td>
                        <td>Ponovite lozinku</td>
                    </tr>
                    <tr>
                        <td><input type="password" id="regLozinka" name="regLozinka" value="{{old('regLozinka')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                        <td><input type="password" id="regLozinka2" name="regLozinka2" value="{{old('regLozinka2')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="regLozinkaGreska" class="ispisGreske"></div>
                        </td>
                        <td>
                            <div id="regLozinka2Greska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Slika</td>
                        <td>Uloga</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="file" id="regSlika" name="regSlika"/>
                        </td>
                        <td>
                            <select id="add_uloga" name="add_uloga">
                                <option value="0">Izaberite</option>
                                @foreach($uloge as $u)
                                    <option value="{{$u->ulogaID}}">{{$u->uloga}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="regSlikaGreska" class="ispisGreske"></div>
                        </td>
                        <td>
                            <div id="addUlogaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Aktivan
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select id="add_aktivan" name="add_aktivan">
                                <option value="2">Izaberite</option>
                                <option value="1">Da</option>
                                <option value="0">Ne</option>
                            </select>
                        </td>
                        <td>
                            <input type="submit" id="addUserDugme" name="addUserDugme" value="DODAJ KORISNIKA" class="inputi_dugme"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="addAktivanGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


    @include('inc.greskelevo')

@endsection