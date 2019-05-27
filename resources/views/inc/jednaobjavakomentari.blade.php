<div id="komentari_naslov">
    <h5>Komentari ({{$brojKomentara}})</h5>
</div>


@if(count($komentari))
    <div id="komentari_sadrzaj">
        @foreach($komentari as $k)
            @if(session('korisnik'))
                @if(session('korisnik')->korisnikID == $k->korisnikID)
                    <a href="#" data-id="{{$k->komentarID}}" class="obrisiKomentar">Obriši komentar</a>
                @endif
            @endif
            <div class="jedankomentar">
                <div class="jedankomentar_slika">
                    <img src="{{asset('images/profile/' . $k->src)}}" alt="{{$k->alt}}" class="jedankomentar_slika_img"/>
                </div>

                <div class="jedankomentar_sadrzaj">
                    <div class="jedankomentar_header">
                        <table class="jedankomentar_header_tabela">
                            <tr>
                                <td>Dodao/la: {{$k->korisnicko_ime}}</td>
                                <td>Postavljeno: {{date('m.d.Y H:i', $k->komentar_created_at)}}h</td>
                            </tr>
                        </table>
                    </div>

                    <div class="jedankomentar_tekst">
                        <p>{{$k->komentar}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div id="nema_komentara">
        Nema komentara
    </div>
@endif


@if(session('korisnik'))

    <div id="dodaj_komentar_naslov">
        Dodajte komentar
    </div>
    <div id="dodaj_komentar_sadrzaj">
        <div id="dodaj_komentar">
            <form>
                <div id="dk_slika_div">
                    <img src="{{asset('images/profile/' . session('korisnik')->src)}}" alt="{{session('korisnik')->alt}}"/>
                </div>

                <div id="dk_tekst_div">
                    <textarea id="dodajKomentarTextarea" name="dodajKomentarTextarea" maxlength="300"></textarea>
                </div>

                <div id="dk_dugme_div">
                    <input type="button" id="dodajKomentarDugme" name="dodajKomentarDugme" value="DODAJ"/>
                </div>
                <input type="hidden" id="dodajKomentarKorisnikID" name="dodajKomentarKorisnikID" value="{{session('korisnik')->korisnikID}}"/>
                <input type="hidden" id="dodajKomentarObjavaID" name="dodajKomentarObjavaID" value="{{$objava->objavaID}}"/>
            </form>
        </div>
        <div id="komentar_greska">

        </div>
    </div>

@else
    <div id="komentari_prijava">
        <br/>
        Morate se prijaviti da bi komentarisali objavu. <a href="{{route('loginpage')}}">Prijavite se</a>
    </div>
@endif