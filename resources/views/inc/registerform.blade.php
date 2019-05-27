<div class="naslov_svaki">
    <p>Registrujte se</p>
</div>
<div id="register_sadrzaj">
    <div id="register_drzac">
        <form id="forma_register" name="forma_register" method="POST" action="{{route('registracija')}}" onSubmit="return regProvera();" enctype="multipart/form-data">
            @csrf
            <table id="tabela_register">
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
                    <td colspan="2">
                        Slika
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="file" id="regSlika" name="regSlika"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="regSlikaGreska" class="ispisGreske"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="regDugme" name="regDugme" value="REGISTRUJ SE" class="inputi_dugme"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>