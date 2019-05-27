@extends('layouts.layout')

@section('title')
    Admin - Izmena kategorije
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Izmenite Kategoriju</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_register" name="forma_register" method="POST" action="{{route('kategorija.update', ['id' => $kategorija->kategorijaID])}}" onSubmit="return addUpdateKategorijaProvera();">
                @csrf
                @method('PUT')
                <table id="tabela_adduser">
                    <tr>
                        <td>Naziv</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="addKategorija" name="addKategorija" value="{{$kategorija->kategorija}}" placeholder="" autocomplete="on" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="addKategorijaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" id="updateKategorijaDugme" name="updateKategorijaDugme" value="IZMENI KATEGORIJU" class="inputi_dugme"/>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="updateKategorijaID" name="updateKategorijaID" value="{{$kategorija->kategorijaID}}"/>
            </form>
        </div>
    </div>


    @include('inc.greske')

@endsection