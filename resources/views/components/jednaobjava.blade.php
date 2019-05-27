<div class="objava_sadrzaj">
    <div class="objava_drzac">
        <table class="objava_tabela">
            <tr>
                <td colspan="3"><h5>{{$objava->naslov}}</h5></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="objava_slika_div">
                        <img src="{{asset('images/objave/' . $objava->src)}}" alt="{{$objava->alt}}" class="objava_slika_img"/>
                    </div>
                </td>
            </tr>
            <tr class="objava_detalji">
                <td>
                    Dodao/la: {{$objava->korisnicko_ime}}
                </td>
                <td>
                    Postavljeno: {{date('m.d.Y H:i', $objava->objava_created_at)}}h
                </td>
                <td>
                    Kategorija: {{$objava->kategorija}}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="objava_tekst">
                        {{substr($objava->tekst, 0, 80)}} ...
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <a href="{{route('jednaObjava', ['objavaID' => $objava->objavaID, 'korisnikID' => (session('korisnik') ? session('korisnik')->korisnikID : 0)])}}" class="detaljnije">PROČITAJ VIŠE</a>
                    @if(session('korisnik'))
                        @if(session('korisnik')->korisnikID == $objava->korisnikID)
                            &nbsp;&nbsp;&nbsp; <a href="{{route('updateobjavauserpage', ['id' => $objava->objavaID])}}">Izmeni</a>
                        @endif
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>