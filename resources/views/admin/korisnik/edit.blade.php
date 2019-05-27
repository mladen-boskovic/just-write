@extends('layouts.layout')

@section('title')
    Admin - Izmena korisnika
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Izmenite Korisnika</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_register" name="forma_register" method="POST" action="{{route('korisnik.update', ['id' => $korisnik->korisnikID])}}" onSubmit="return updateUserProvera();" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table id="tabela_adduser">
                    <tr>
                        <td colspan="2" id="updateUserSlikaSredina">
                            <a href="{{asset('images/profile/' . $korisnik->src)}}" class="vecaSlika">
                                <img src="{{asset('images/profile/' . $korisnik->src)}}" alt="{{$korisnik->alt}}" id="updateUserSlika"/>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                    <tr>
                        <td>Ime</td>
                        <td>Prezime</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="regIme" name="regIme" value="{{$korisnik->ime}}" placeholder="" autocomplete="on" class="inputi"/></td>
                        <td><input type="text" id="regPrezime" name="regPrezime" value="{{$korisnik->prezime}}" placeholder="" autocomplete="on" class="inputi"/></td>
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
                        <td><input type="text" id="regEmail" name="regEmail" value="{{$korisnik->email}}" placeholder="" autocomplete="on" class="inputi"/></td>
                        <td><input type="text" id="regKorIme" name="regKorIme" value="{{$korisnik->korisnicko_ime}}" placeholder="" autocomplete="on" class="inputi"/></td>
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
                                    @if($korisnik->ulogaID == $u->ulogaID)
                                        <option value="{{$u->ulogaID}}" selected>{{$u->uloga}}</option>
                                    @else
                                        <option value="{{$u->ulogaID}}">{{$u->uloga}}</option>
                                    @endif
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
                                @if($korisnik->aktivan == 1)
                                    <option value="1" selected>Da</option>
                                    <option value="0">Ne</option>
                                @else
                                    <option value="1">Da</option>
                                    <option value="0" selected>Ne</option>
                                @endif
                            </select>
                        </td>
                        <td>
                            <input type="submit" id="updateUserDugme" name="updateUserDugme" value="IZMENI KORISNIKA" class="inputi_dugme"/>
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

    @include('inc.greske')

@endsection