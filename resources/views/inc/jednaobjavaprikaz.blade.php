<div id="jednaobjava_sadrzaj">
    <div id="jednaobjava_drzac">
        <table id="jednaobjava_tabela">
            <tr>
               <td colspan="5">
                   <h5>{{$objava->naslov}}</h5>
               </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div id="jednaobjava_slika_div">
                        <a href="{{asset('images/objave/' . $objava->src)}}" class="vecaSlika">
                            <img src="{{asset('images/objave/' . $objava->src)}}" alt="{{$objava->alt}}" id="jednaobjava_slika_img"/>
                        </a>
                    </div>
                </td>
            </tr>

            <tr id="objava_header_tekst">
                <td>Dodao/la: <br/>{{$objava->korisnicko_ime}}</td>
                <td>Postavljeno: <br/>{{date('m.d.Y H:i', $objava->objava_created_at)}}h</td>
                <td>Zadnja izmena: <br/>{{date('m.d.Y H:i', $objava->objava_updated_at)}}h</td>
                <td>Kategorija: <br/>{{$objava->kategorija}}</td>

                @if(session('korisnik'))
                    <td>
                        @if($korisnikLajkovao)
                            <a href="#" data-id="{{$objava->objavaID}}" class="lajkovanjeLink"><i class="fas fa-thumbs-up" style="color:#7971ea"></i></a> <br/>
                        @elseif($korisnikLajkovao == null)
                            <a href="#" data-id="{{$objava->objavaID}}" class="lajkovanjeLink"><i class="fas fa-thumbs-up" style="color:#707070"></i></a> <br/>
                        @elseif($korisnikLajkovao == "0")
                            <a href="#" data-id="{{$objava->objavaID}}" id="lajkovanjeProvera"><i class="fas fa-thumbs-up" style="color:#707070"></i></a> <br/>
                        @endif
                        {{$brojLajkova}}
                    </td>
                @else
                    <td>
                        <a href="#" data-id="{{$objava->objavaID}}" id="lajkovanjeProvera"><i class="fas fa-thumbs-up" style="color:#707070"></i></a> <br/>
                        {{$brojLajkova}}
                    </td>
                @endif

            </tr>

            <tr>
                <td colspan="5">
                    <div id="jednaobjava_tekst">
                        {{$objava->tekst}}
                    </div>
                </td>
            </tr>
            @if(session('korisnik'))
                @if(session('korisnik')->korisnikID == $objava->korisnikID)
                    <tr>
                        <td colspan="5">
                            <a href="{{route('updateobjavauserpage', ['id' => $objava->objavaID])}}" class="detaljnije">Izmeni Objavu</a>
                        </td>
                    </tr>
                @endif
            @endif
        </table>
    </div>
</div>