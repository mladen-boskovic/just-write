@extends('layouts.layout')

@section('title')
    Admin - Izmena objave
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Izmenite Objavu</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_addObjava" name="forma_addObjava" method="POST" action="{{route('objava.update', ['id' => $objava->objavaID])}}" onSubmit="return updateObjavaProvera();" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table id="tabela_addObjava">
                    <tr>
                        <td colspan="2" id="updateObjavaSlikaSredina">
                            <a href="{{asset('images/objave/' . $objava->src)}}" class="vecaSlika">
                                <img src="{{asset('images/objave/' . $objava->src)}}" alt="{{$objava->alt}}" id="updateObjavaSlika"/>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Naslov</td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea id="addObjavaNaslov" name="addObjavaNaslov" maxlength="100">{{$objava->naslov}}</textarea></td>
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
                        <td colspan="2"><textarea id="addObjavaTekst" name="addObjavaTekst" maxlength="1000">{{$objava->tekst}}</textarea></td>
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
                                    @if($objava->kategorijaID == $k->kategorijaID)
                                        <option value="{{$k->kategorijaID}}" selected>{{$k->kategorija}}</option>
                                    @else
                                        <option value="{{$k->kategorijaID}}">{{$k->kategorija}}</option>
                                    @endif
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
                            <input type="submit" id="updateObjavaDugme" name="updateObjavaDugme" value="IZMENI OBJAVU" class="inputi_dugme"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


    @include('inc.greskelevo')

@endsection