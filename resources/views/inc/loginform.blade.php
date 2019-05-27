<div class="naslov_svaki">
    <p>Prijavite se</p>
</div>
<div id="login_sadrzaj">
    <div id="login_drzac">
        <form id="forma_login" name="forma_login" method="POST" action="{{route('prijava')}}" onSubmit="return loginProvera();">
            @csrf
            <table id="tabela_login">
                <tr>
                    <td>Korisničko ime</td>
                </tr>
                <tr>
                    <td><input type="text" id="loginKorIme" value="{{old('loginKorIme')}}" name="loginKorIme" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="loginKorImeGreska" class="ispisGreske">
                            @if(session('loginGreskaPoruka'))
                                {{session('loginGreskaPoruka')}}
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Lozinka</td>
                </tr>
                <tr>
                    <td><input type="password" id="loginLozinka" name="loginLozinka" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="loginLozinkaGreska" class="ispisGreske">
                            @if(session('loginGreskaPoruka'))
                                {{session('loginGreskaPoruka')}}
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" id="loginDugme" name="loginDugme" value="PRIJAVI SE" class="inputi_dugme"/></td>
                </tr>
            </table>
            <br/>
            <a href="{{route('registerpage')}}">Niste registrovani?</a><br/>
            <p id="zab_loz_p">Zaboravili ste lozinku?</p>
        </form>
    </div>
</div>