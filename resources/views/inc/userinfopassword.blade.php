<div class="naslov_svaki">
    <p>Vaš Profil</p>
</div>
<div id="profile_sadrzaj">
    <div id="profile_drzac">

        <div id="o_korisniku">
            <div id="user_profile_image">
                <form method="POST" action="{{route('promenaProfilneSlike')}}" onSubmit="return promenaProfilneSlike();" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table>
                        <tr>
                            <td colspan="2">
                                Vaša slika:
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="profil_slika_centar">
                                <a href="{{asset('images/profile/' . session('korisnik')->src)}}" class="vecaSlika">
                                    <img src="{{asset('images/profile/' . session('korisnik')->src)}}" alt="{{session('korisnik')->alt}}"/>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="file" id="profilnaSlika" name="profilnaSlika"/>
                            </td>
                            <td>
                                <input type="submit" id="promenaSlikeDugme" name="promenaSlikeDugme" value="PROMENI SLIKU" class="inputi_dugme"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="promenaProfilneSlikeGreske">
                                    @if($errors->any())
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if(session('promenaSlikeUspesno'))
                                        {{session('promenaSlikeUspesno')}}
                                    @endif

                                    @if(session('promenaSlikeNeuspesno'))
                                        {{session('promenaSlikeNeuspesno')}}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="promenaProfilneSlikeKorisnik" name="promenaProfilneSlikeKorisnik" value="{{session('korisnik')->korisnikID}}"/>
                </form>
            </div>


        </div>



        <div id="promena_lozinke">
            <form id="formaPromenaLozinke" name="formaPromenaLozinke">
                <table id="tabela_promeni_lozinku">
                    <tr>
                        <td>Trenutna lozinka</td>
                    </tr>
                    <tr>
                        <td><input type="password" id="trenutnaLozinka" name="trenutnaLozinka" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="trenutnaLozinkaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Nova lozinka</td>
                    </tr>
                    <tr>
                        <td><input type="password" id="novaLozinka" name="novaLozinka" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="novaLozinkaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Ponovite novu lozinku</td>
                    </tr>
                    <tr>
                        <td><input type="password" id="novaLozinka2" name="novaLozinka2" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="novaLozinkaGreska2" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" id="promenaLozinkeDugme" name="promenaLozinkeDugme" value="PROMENI LOZNKU" class="inputi_dugme"/></td>
                    </tr>
                </table>
                <input type="hidden" id="promenaLozinkeKorisnik" name="promenaLozinkeKorisnik" value="{{session('korisnik')->korisnikID}}"/>
            </form>

            <div id="promenaLozinkeGreske">
            </div>
        </div>
    </div>


    <div id="user_info">
        <table>
            <tr>
                <th colspan="2"> Podaci</th>
            </tr>
            <tr>
                <td>Ime</td>
                <td>{{session('korisnik')->ime}}</td>
            </tr>
            <tr>
                <td>Prezime</td>
                <td>{{session('korisnik')->prezime}}</td>
            </tr>
            <tr>
                <td>Korisničko ime</td>
                <td>{{session('korisnik')->korisnicko_ime}}</td>
            </tr>
            <tr>
                <td>Uloga</td>
                <td>{{session('korisnik')->uloga}}</td>
            </tr>
            <tr>
                <td>Datum registracije</td>
                <td>{{date("d.m.Y H:i", session('korisnik')->datum_registracije)}}h</td>
            </tr>
        </table>
    </div>

</div>

<div class="ucitavanje">
</div>