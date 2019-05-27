@extends('layouts.layout')

@section('title')
    Admin - Dodavanje kategorije
@endsection

@section('sadrzaj')
    @include('admin.adminmenu')

    <div class="naslov_svaki">
        <p>Dodajte Kategoriju</p>
    </div>
    <div id="register_sadrzaj">
        <div id="register_drzac">
            <form id="forma_register" name="forma_register" method="POST" action="{{route('kategorija.store')}}" onSubmit="return addUpdateKategorijaProvera();">
                @csrf
                <table id="tabela_adduser">
                    <tr>
                        <td>Naziv</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="addKategorija" name="addKategorija" value="{{old('addKategorija')}}" placeholder="" autocomplete="on" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="addKategorijaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" id="addKategorijaDugme" name="addKategorijaDugme" value="DODAJ KATEGORIJU" class="inputi_dugme"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


    @include('inc.greske')

@endsection