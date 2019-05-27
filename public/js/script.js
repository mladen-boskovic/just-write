$(document).ready(function () {
    $('#loginKorIme').focus();
    $('#zab_loz_p').on('click', prikaziSakrijResetovanje);
    $('#zab_loz_div').hide();
    $('#resetPassEmailIspis').hide();
    $('#resetPassEmailDugme').on('click', resetPassEmailProvera);
    $('#resetLozinkeDugme').on('click', resetLozinke);
    $('.vecaSlika').simpleLightbox();
    $('#promenaLozinkeDugme').on('click', promenaLozinke);
    $('.obrisiKorisnika').on('click', obrisiKorisnika);
    $('.obrisiObjavu').on('click', obrisiObjavu);
    $('.obrisiKomentar').on('click', obrisiKomentar);
    $('#dodajKomentarDugme').on('click', dodajKomentar);
    $('.lajkovanjeLink').on('click', lajkovanje);
    $('#lajkovanjeProvera').on('click', lajkovanjeProvera);
    $('.obrisiKategoriju').on('click', obrisiKategoriju);


    $('#nav li').hover(
        function() {
            $('ul', this).stop().slideDown(200);
        },
        function() {
            $('ul', this).stop().slideUp(200);
        }
    );


    prikaziSveObjaveAjax();
    $('#searchButton').on('click', prikaziSveObjaveAjax);
    $('#sortiraj').on('change', prikaziSveObjaveAjax);
    $('.kategorija_filter').on('click', prikaziSveObjaveAjax);


    $(document).on({
        ajaxStart: function() { $('body').addClass("loading"); },
        ajaxStop: function() { $('body').removeClass("loading"); }
    });

});


function regProvera() {
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var regLozinka = $('#regLozinka').val();
    var regLozinka2 = $('#regLozinka2').val();
    var regSlika = $('#regSlika').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];

    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
        $('#regImeGreska').html("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
        $('#regImeGreska').html("Ime nije u dobrom formatu");
    } else{
        $('#regImeGreska').html("");
    }

    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
        $('#regPrezimeGreska').html("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
        $('#regPrezimeGreska').html("Prezime nije u dobrom formatu");
    } else{
        $('#regPrezimeGreska').html("");
    }

    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
        $('#regEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
        $('#regEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#regEmailGreska').html("");
    }

    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#regKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
        $('#regKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
    } else{
        $('#regKorImeGreska').html("");
    }

    if(regLozinka === ""){
        regGreske.push("Polje za lozinku mora biti popunjeno");
        $('#regLozinkaGreska').html("Polje za lozinku mora biti popunjeno");
    } else if(regLozinka.length < 6){
        regGreske.push("Lozinka mora imati bar 6 karaktera");
        $('#regLozinkaGreska').html("Lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka2 !== "") && (regLozinka2.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinkaGreska').html("");
    }

    if(regLozinka2 === ""){
        regGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#regLozinka2Greska').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(regLozinka2.length < 6){
        regGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#regLozinka2Greska').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka !== "") && (regLozinka.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinka2Greska').html("");
    }

    if(regSlika === ""){
        regGreske.push("Morate odabrati sliku");
        $('#regSlikaGreska').html("Morate odabrati sliku");
    } else{
        $('#regSlikaGreska').html("");
    }

    return (regGreske.length > 0) ? false : true;

}

function loginProvera() {
    var loginKorIme = $.trim($('#loginKorIme').val());
    var loginLozinka = $('#loginLozinka').val();
    var reLoginKorIme = /^[\w\d\.\_]{5,15}$/;
    var loginGreske = [];

    if(loginKorIme === ""){
        loginGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#loginKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!reLoginKorIme.test(loginKorIme)){
        loginGreske.push("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
        $('#loginKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
    } else{
        $('#loginKorImeGreska').html("");
    }

    if(loginLozinka === ""){
        loginGreske.push("Polje za lozinku mora biti popunjeno");
        $('#loginLozinkaGreska').html("Polje za lozinku mora biti popunjeno");
    } else if(loginLozinka.length < 6){
        loginGreske.push("Lozinka mora imati bar 6 karaktera");
        $('#loginLozinkaGreska').html("Lozinka mora imati bar 6 karaktera");
    } else{
        $('#loginLozinkaGreska').html("");
    }

    return (loginGreske.length > 0) ? false : true;
}

function prikaziSakrijResetovanje() {
    $('#zab_loz_div').toggle();
    $('#resetPassEmailIspis').toggle();
    $('#resetPassEmailIspis').html("");
    $('#resetPassEmail').val("");
}

function resetPassEmailProvera() {
    var email = $.trim($('#resetPassEmail').val());
    var proveraEmail = /^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var greska = "";

    if(email === ""){
        greska = "Polje za email mora biti popunjeno";
        $('#resetPassEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(email)){
        greska = "Email nije u dobrom formatu";
        $('#resetPassEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#resetPassEmailGreska').html("");
    }

    if(greska === ""){
        var data = {
            email : email
        };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/resetpassword/emailcheck",
            method : "PUT",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#resetPassEmailIspis').html("<h4>" + data + "</h4>");

                if(data === "Proverite email za nastavak procesa . . . . ."){
                    $('#resetPassEmail').val("");
                    setTimeout(function() {
                        $('#resetPassEmailIspis').html("");
                    }, 7500);
                } else{
                    setTimeout(function() {
                        $('#resetPassEmailIspis').html("");
                        $('#resetPassEmail').val("");
                    }, 7500);
                }
            },
            error : function (xhr, status, error) {
                var ispis = "";
                try{
                    var greske = xhr.responseJSON.errors;
                    ispis = "<ul>";
                    $.each(greske, function(key, value) {
                        ispis += "<li><h5>" + value + "</h5></li>";
                    });
                    ispis += "</ul>";
                } catch (e) {

                }
                $('#resetPassEmailIspis').html(ispis);
            }
        });
    }
}

function resetLozinke() {
    var token = $('#promenaLozinkeKorisnikToken').val();
    var novaLozinka = $('#novaLozinka').val();
    var novaLozinka2 = $('#novaLozinka2').val();

    var promenaLozinkeGreske = [];

    if(novaLozinka === ""){
        promenaLozinkeGreske.push("Polje za novu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska').html("Polje za novu lozinku mora biti popunjeno");
    } else if(novaLozinka.length < 6){
        promenaLozinkeGreske.push("Nova lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska').html("Nova lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka2 !== "") && (novaLozinka2.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska').html("");
    }

    if(novaLozinka2 === ""){
        promenaLozinkeGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska2').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(novaLozinka2.length < 6){
        promenaLozinkeGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska2').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka !== "") && (novaLozinka.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska2').html("");
    }

    if(promenaLozinkeGreske.length == 0){
        var data =
            {
                token : token,
                novaLozinka : novaLozinka,
                novaLozinka2 : novaLozinka2
            };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/resetpassword",
            method : "PUT",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#resetLozinkeGreske').html("<h4>" + data + "</h4>");
                if(data === "Uspešno ste promenili lozinku!"){
                    $('#novaLozinka').val("");
                    $('#novaLozinka2').val("");
                    setTimeout(function() {
                        window.location.href = baseUrl + "/login";
                    }, 5000);
                } else{
                    setTimeout(function() {
                        window.location.href = baseUrl;
                    }, 5000);
                }
            },
            error : function (xhr, status, error) {
                var ispis = "";
                try{
                    var greske = xhr.responseJSON.errors;
                    ispis = "<ul>";
                    $.each(greske, function(key, value) {
                        ispis += "<li><h5>" + value + "</h5></li>";
                    });
                    ispis += "</ul>";
                } catch (e) {

                }
                $('#resetLozinkeGreske').html(ispis);
            }
        });
    }
}

function promenaProfilneSlike() {
    var profilnaSlika = $('#profilnaSlika').val();
    var greske = [];

    if(profilnaSlika === ""){
        greske.push("Morate odabrati sliku");
        $('#promenaProfilneSlikeGreske').html("Morate odabrati sliku");
    } else{
        $('#promenaProfilneSlikeGreske').html("");
    }

    return (greske.length > 0) ? false : true;
}

function promenaLozinke() {
    var korisnikID = $('#promenaLozinkeKorisnik').val();
    var trenutnaLozinka = $('#trenutnaLozinka').val();
    var novaLozinka = $('#novaLozinka').val();
    var novaLozinka2 = $('#novaLozinka2').val();

    var promenaLozinkeGreske = [];

    if(trenutnaLozinka === ""){
        promenaLozinkeGreske.push("Polje za trenutnu lozinku mora biti popunjeno");
        $('#trenutnaLozinkaGreska').html("Polje za trenutnu lozinku mora biti popunjeno");
    } else if(trenutnaLozinka.length < 6){
        promenaLozinkeGreske.push("Trenutna lozinka mora imati bar 6 karaktera");
        $('#trenutnaLozinkaGreska').html("Trenutna lozinka mora imati bar 6 karaktera");
    } else{
        $('#trenutnaLozinkaGreska').html("");
    }


    if(novaLozinka === ""){
        promenaLozinkeGreske.push("Polje za novu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska').html("Polje za novu lozinku mora biti popunjeno");
    } else if(novaLozinka.length < 6){
        promenaLozinkeGreske.push("Nova lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska').html("Nova lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka2 !== "") && (novaLozinka2.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska').html("");
    }

    if(novaLozinka2 === ""){
        promenaLozinkeGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska2').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(novaLozinka2.length < 6){
        promenaLozinkeGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska2').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka !== "") && (novaLozinka.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska2').html("");
    }


    if(promenaLozinkeGreske.length == 0){
        var data = {
            korisnikID : korisnikID,
            trenutnaLozinka : trenutnaLozinka,
            novaLozinka : novaLozinka,
            novaLozinka2 : novaLozinka2
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/changepassword",
            method : "PUT",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#promenaLozinkeGreske').html("<h4>" + data + "</h4>");

                if(data === "Uspešno ste promenili lozinku!"){
                    $('#trenutnaLozinka').val("");
                    $('#novaLozinka').val("");
                    $('#novaLozinka2').val("");
                    setTimeout(function() {
                        $('#promenaLozinkeGreske').html("");
                    }, 7500);
                } else{
                    setTimeout(function() {
                        $('#promenaLozinkeGreske').html("");
                    }, 7500);
                }
            },
            error : function (xhr, status, error) {
                var ispis = "";
                try{
                    var greske = xhr.responseJSON.errors;
                    ispis = "<ul>";
                    $.each(greske, function(key, value) {
                        ispis += "<li><h5>" + value + "</h5></li>";
                    });
                    ispis += "</ul>";
                } catch (e) {

                }
                $('#promenaLozinkeGreske').html(ispis);
            }
        });
    }
}

function contactProvera() {
    var contactEmail = $.trim($('#contactEmail').val());
    var poruka= $('#poruka').val();
    var reContactEmail = /^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var contactGreske = [];

    if(contactEmail === ""){
        contactGreske.push("Polje za email mora biti popunjeno");
        $("#contactEmailGreska").html("Polje za email mora biti popunjeno");
    } else if(!reContactEmail.test(contactEmail)){
        contactGreske.push("Email nije u dobrom formatu");
        $("#contactEmailGreska").html("Email nije u dobrom formatu");
    } else{
        $("#contactEmailGreska").html("");
    }

    if(poruka === ""){
        contactGreske.push("Polje za poruku mora biti popunjeno");
        $("#contactPorukaGreska").html("Polje za poruku mora biti popunjeno");
    } else if(poruka.length < 15 || poruka.length > 500){
        contactGreske.push("Poruka mora imati 15-500 karaktera");
        $("#contactPorukaGreska").html("Poruka mora imati 15-500 karaktera");
    } else{
        $("#contactPorukaGreska").html("");
    }

    return (contactGreske.length > 0) ? false : true;
}

function addUserProvera(){
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var regLozinka = $('#regLozinka').val();
    var regLozinka2 = $('#regLozinka2').val();
    var regSlika = $('#regSlika').val();
    var uloga = $('#add_uloga').val();
    var aktivan = $('#add_aktivan').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];


    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
        $('#regImeGreska').html("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
        $('#regImeGreska').html("Ime nije u dobrom formatu");
    } else{
        $('#regImeGreska').html("");
    }

    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
        $('#regPrezimeGreska').html("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
        $('#regPrezimeGreska').html("Prezime nije u dobrom formatu");
    } else{
        $('#regPrezimeGreska').html("");
    }

    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
        $('#regEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
        $('#regEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#regEmailGreska').html("");
    }

    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#regKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
        $('#regKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
    } else{
        $('#regKorImeGreska').html("");
    }

    if(regLozinka === ""){
        regGreske.push("Polje za lozinku mora biti popunjeno");
        $('#regLozinkaGreska').html("Polje za lozinku mora biti popunjeno");
    } else if(regLozinka.length < 6){
        regGreske.push("Lozinka mora imati bar 6 karaktera");
        $('#regLozinkaGreska').html("Lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka2 !== "") && (regLozinka2.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinkaGreska').html("");
    }

    if(regLozinka2 === ""){
        regGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#regLozinka2Greska').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(regLozinka2.length < 6){
        regGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#regLozinka2Greska').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka !== "") && (regLozinka.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinka2Greska').html("");
    }

    if(regSlika === ""){
        regGreske.push("Morate odabrati sliku");
        $('#regSlikaGreska').html("Morate odabrati sliku");
    } else{
        $('#regSlikaGreska').html("");
    }

    if(uloga === "0"){
        regGreske.push("Morate odabrati ulogu");
        $('#addUlogaGreska').html("Morate odabrati ulogu");
    } else{
        $('#addUlogaGreska').html("");
    }

    if(aktivan === "2"){
        regGreske.push("Morate odabrati aktivnost korisnika");
        $('#addAktivanGreska').html("Morate odabrati aktivnost korisnika");
    } else{
        $('#addAktivanGreska').html("");
    }

    return (regGreske.length > 0) ? false : true;
}

function updateUserProvera(){
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var uloga = $('#add_uloga').val();
    var aktivan = $('#add_aktivan').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];


    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
        $('#regImeGreska').html("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
        $('#regImeGreska').html("Ime nije u dobrom formatu");
    } else{
        $('#regImeGreska').html("");
    }

    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
        $('#regPrezimeGreska').html("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
        $('#regPrezimeGreska').html("Prezime nije u dobrom formatu");
    } else{
        $('#regPrezimeGreska').html("");
    }

    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
        $('#regEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
        $('#regEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#regEmailGreska').html("");
    }

    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#regKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
        $('#regKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera<br/>Sme da sadrži slova, brojeve, tačku i donju crtu");
    } else{
        $('#regKorImeGreska').html("");
    }

    if(uloga === "0"){
        regGreske.push("Morate odabrati ulogu");
        $('#addUlogaGreska').html("Morate odabrati ulogu");
    } else{
        $('#addUlogaGreska').html("");
    }

    if(aktivan === "2"){
        regGreske.push("Morate odabrati aktivnost korisnika");
        $('#addAktivanGreska').html("Morate odabrati aktivnost korisnika");
    } else{
        $('#addAktivanGreska').html("");
    }

    return (regGreske.length > 0) ? false : true;
}

function obrisiKorisnika(e) {
    if(confirm("Da li želite da obrišete korisnika?")){
        var id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/admin/korisnik/" + id,
            method : "DELETE",
            success : function (data) {
                alert(data);
                location.reload();
            },
            error : function (xhr,status, error) {
                alert("Greška pri brisanju korisnika, pokušajte kasnije");
                location.reload();
            }
        });
    }
    e.preventDefault();
}

function addObjavaProvera() {
    var naslov = $('#addObjavaNaslov').val();
    var tekst = $('#addObjavaTekst').val();
    var kategorija = $('#addObjavaKategorija').val();
    var slika = $('#addObjavaSlika').val();
    var addObjavaGreske = [];

    if(naslov === ""){
        addObjavaGreske.push("Polje za naslov mora biti popunjeno");
        $("#addObjavaNaslovGreska").html("Polje za naslov mora biti popunjeno");
    } else if(naslov.length < 15 || naslov.length > 100){
        addObjavaGreske.push("Naslov mora imati 15-100 karaktera");
        $("#addObjavaNaslovGreska").html("Naslov mora imati 15-100 karaktera");
    } else{
        $("#addObjavaNaslovGreska").html("");
    }

    if(tekst === ""){
        addObjavaGreske.push("Polje za tekst mora biti popunjeno");
        $("#addObjavaTekstGreska").html("Polje za tekst mora biti popunjeno");
    } else if(tekst.length < 100 || tekst.length > 1000){
        addObjavaGreske.push("Tekst mora imati 100-1000 karaktera");
        $("#addObjavaTekstGreska").html("Tekst mora imati 100-1000 karaktera");
    } else{
        $("#addObjavaTekstGreska").html("");
    }

    if(kategorija === "0"){
        addObjavaGreske.push("Morate odabrati kategoriju");
        $('#addObjavaKategorijaGreska').html("Morate odabrati kategoriju");
    } else{
        $('#addObjavaKategorijaGreska').html("");
    }

    if(slika === ""){
        addObjavaGreske.push("Morate odabrati sliku");
        $('#addObjavaSlikaGreska').html("Morate odabrati sliku");
    } else{
        $('#addObjavaSlikaGreska').html("");
    }

    return (addObjavaGreske.length > 0) ? false : true;
}

function updateObjavaProvera() {
    var naslov = $('#addObjavaNaslov').val();
    var tekst = $('#addObjavaTekst').val();
    var kategorija = $('#addObjavaKategorija').val();
    var updateObjavaGreske = [];

    if(naslov === ""){
        updateObjavaGreske.push("Polje za naslov mora biti popunjeno");
        $("#addObjavaNaslovGreska").html("Polje za naslov mora biti popunjeno");
    } else if(naslov.length < 15 || naslov.length > 100){
        updateObjavaGreske.push("Naslov mora imati 15-100 karaktera");
        $("#addObjavaNaslovGreska").html("Naslov mora imati 15-100 karaktera");
    } else{
        $("#addObjavaNaslovGreska").html("");
    }

    if(tekst === ""){
        updateObjavaGreske.push("Polje za tekst mora biti popunjeno");
        $("#addObjavaTekstGreska").html("Polje za tekst mora biti popunjeno");
    } else if(tekst.length < 100 || tekst.length > 1000){
        updateObjavaGreske.push("Tekst mora imati 100-1000 karaktera");
        $("#addObjavaTekstGreska").html("Tekst mora imati 100-1000 karaktera");
    } else{
        $("#addObjavaTekstGreska").html("");
    }

    if(kategorija === "0"){
        updateObjavaGreske.push("Morate odabrati kategoriju");
        $('#addObjavaKategorijaGreska').html("Morate odabrati kategoriju");
    } else{
        $('#addObjavaKategorijaGreska').html("");
    }

    return (updateObjavaGreske.length > 0) ? false : true;
}

function obrisiObjavu(e) {
    if(confirm("Da li želite da obrišete objavu?")){
        var id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/admin/objava/" + id,
            method : "DELETE",
            success : function (data) {
                alert(data);
                location.reload();
            },
            error : function (xhr,status, error) {
                alert("Greška pri brisanju objave, pokušajte kasnije");
                location.reload();
            }
        });
    }
    e.preventDefault();
}

function obrisiKomentar(e) {
    if(confirm("Da li želite da obrišete komentar?")){
        var id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/admin/komentar/" + id,
            method : "DELETE",
            success : function (data) {
                alert(data);
                location.reload();
            },
            error : function (xhr,status, error) {
                alert("Greška pri brisanju komentara, pokušajte kasnije");
                location.reload();
            }
        });
    }
    e.preventDefault();
}

function dodajKomentar(e) {
    var komentar = $.trim($('#dodajKomentarTextarea').val());
    var korisnikID = $('#dodajKomentarKorisnikID').val();
    var objavaID = $('#dodajKomentarObjavaID').val();
    var komentarGreska = [];

    if(komentar === ""){
        komentarGreska.push("Polje za komentar mora biti popunjeno");
        $('#komentar_greska').html("Polje za komentar mora biti popunjeno");
    } else if(komentar.length < 2 || komentar.length > 300){
        komentarGreska.push("Komentar mora imati 2-300 karaktera");
        $('#komentar_greska').html("Komentar mora imati 2-300 karaktera");
    } else{
        $('#komentar_greska').html("");
    }


    if(komentarGreska.length == 0){
        var data =
            {
                komentar : komentar,
                korisnikID : korisnikID,
                objavaID : objavaID
            };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/admin/komentar",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                alert(data);
                location.reload();
            },
            error : function (xhr, status, error) {
                var ispis = "";
                try{
                    var greske = xhr.responseJSON.errors;
                    ispis = "<ul>";
                    $.each(greske, function(key, value) {
                        ispis += "<li><h5>" + value + "</h5></li>";
                    });
                    ispis += "</ul>";
                } catch (e) {

                }
                $('#komentar_greska').html(ispis);
            }
        });
    }
    e.preventDefault();
}

function lajkovanjeProvera() {
    alert('Morate se prijaviti da bi lajkovali');
}

function lajkovanje(e) {
    var objavaID = $(this).data('id');
    var korisnikID = $('#dodajKomentarKorisnikID').val();

    var data =
        {
            korisnikID : korisnikID,
            objavaID : objavaID
        };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : baseUrl + "/lajkovanje",
        method : "POST",
        dataType : "json",
        data : data,
        success : function (data) {
            if(data === ""){
                location.reload();
            } else{
                alert(data);
                location.reload();
            }
        },
        error : function (xhr, status, error) {
            alert('Greška pri lajkovanju, pokušajte kasnije');
            location.reload();
        }
    });
    e.preventDefault();
}

function addUpdateKategorijaProvera() {
    var kategorija = $.trim($('#addKategorija').val());
    var kategorijaGreska = [];

    if(kategorija === ""){
        kategorijaGreska.push("Polje za naziv mora biti popunjeno");
        $('#addKategorijaGreska').html("Polje za naziv mora biti popunjeno");
    } else if(kategorija.length < 2 || kategorija.length > 20){
        kategorijaGreska.push("Naziv mora imati 2-20 karaktera");
        $('#addKategorijaGreska').html("Naziv mora imati 2-20 karaktera");
    } else{
        $('#addKategorijaGreska').html("");
    }

    return (kategorijaGreska.length > 0) ? false : true;
}

function obrisiKategoriju(e) {
    if(confirm("Da li želite da obrišete kategoriju?")){
        var id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : baseUrl + "/admin/kategorija/" + id,
            method : "DELETE",
            success : function (data) {
                alert(data);
                location.reload();
            },
            error : function (xhr,status, error) {
                alert("Greška pri brisanju kategorije, pokušajte kasnije");
                location.reload();
            }
        });
    }
    e.preventDefault();
}

function prikaziSveObjaveAjax() {
    var korisnikID = $('#objavepageKorisnikID').val();
    if(!korisnikID)
        korisnikID = 0;
    var unos = $('#searchInput').val();
    var kojaStranicaKlik = $(this).data('id');

    var sortiraj = $('#sortiraj').val();
    var kategorija = document.getElementsByName("kategorija_filter");
    var kategorijaNiz = [];

    for(let i=0; i<kategorija.length; i++)
    {
        if(kategorija[i].checked)
            kategorijaNiz.push(kategorija[i].value);
    }

    var kategorijeStr = "";

    if(kategorijaNiz.length){
        kategorijeStr = kategorijaNiz.join(", ");
    }

    var data = {
        unos : unos,
        kategorijeStr : kategorijeStr,
        sortiraj : sortiraj
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : baseUrl + "/objaveajax",
        data : data,
        method : "POST",
        dataType : "json",
        success : function (data) {

            if(!data.length){
                //ako nema objava

                var nemaObjava = "<h4 style='margin-right: 400px;margin-top: 200px;'>Nema objava</h4>";
                $('#objave_objavepage').html(nemaObjava);
                $('.straniceAjax').html("");

            } else{
                var kojaStranica = kojaStranicaKlik ? kojaStranicaKlik : 1;
                var poStranici = 3;
                var brojObjava = data.length;
                var brojStranica = Math.ceil(brojObjava/poStranici);
                var from = poStranici * (kojaStranica - 1);
                var doKog = ((from+poStranici) > brojObjava) ? brojObjava : (from+poStranici);


                var ispisStranica = "";
                for(let i=0; i<brojStranica; i++)
                {
                    ispisStranica += "<a href='#' data-id='"+ (i+1) +"' class='straniceLinkAjax'>"+ (i+1) +"</a>";

                }

                $('.straniceAjax').html(ispisStranica);
                $('.straniceLinkAjax').on('click', prikaziSveObjaveAjax);


                var ispis = "";
                for(let i=from; i<doKog; i++)
                {
                    let tekst = data[i].tekst.substring(0, 80);
                    let izmeni = "";
                    let datum = new Date(data[i].objava_created_at * 1000);
                    //datum.setHours(datum.getHours() - 1);
                    //datum.setMonth(datum.getMonth() + 1);
                    if(korisnikID){
                        if(korisnikID == data[i].korisnikID)
                            izmeni = "&nbsp;&nbsp;&nbsp; <a href='" + baseUrl + "/updateobjavauser/"+ data[i].objavaID +"'>Izmeni</a>";
                    }

                    ispis += "<div class='objava_sadrzaj'>";
                    ispis += "<div class='objava_drzac_objavepage'>";
                    ispis += "<table class='objava_tabela'>";
                    ispis += "<tr>";
                    ispis += "<td colspan='3'><h5>" + data[i].naslov + "</h5></td>";
                    ispis += "</tr>";
                    ispis += "<tr>";
                    ispis += "<td colspan='3'>";
                    ispis += "<div class='objava_slika_div'>";
                    ispis += "<img src='" + baseUrl + "/images/objave/"+ data[i].src +"' alt='"+ data[i].alt +"' class='objava_slika_img'/>";
                    ispis += "</div>";
                    ispis += "</td>";
                    ispis += "</tr>";
                    ispis += "<tr class='objava_detalji'>";
                    ispis += "<td>";
                    ispis += "Dodao/la: " + data[i].korisnicko_ime;
                    ispis += "</td>";
                    ispis += "<td>";
                    ispis += "Postavljeno: " + datum.getDate() +"."+ (datum.getMonth() + 1) +"."+ datum.getFullYear() + ".";
                    ispis += "</td>";
                    ispis += "<td>";
                    ispis += "Kategorija: " + data[i].kategorija;
                    ispis += "</td>";
                    ispis += "</tr>";
                    ispis += "<tr>";
                    ispis += "<td colspan='3'>";
                    ispis += "<div class='objava_tekst'>";
                    ispis += tekst + " ...";
                    ispis += "</div>";
                    ispis += "</td>";
                    ispis += "</tr>";
                    ispis += "<tr>";
                    ispis += "<td colspan='3'>";
                    ispis += "<a href='" + baseUrl + "/objava/"+ data[i].objavaID +"/"+ korisnikID +"' class='detaljnije'>PROČITAJ VIŠE</a>";
                    ispis += izmeni;
                    ispis += "</td>";
                    ispis += "</tr>";
                    ispis += "</table>";
                    ispis += "</div>";
                    ispis += "</div>";
                    ispis += "<br/><br/>";

                    if(!(i == (doKog - 1)))
                        ispis += "<div class='razvdavanje_objava'></div>";

                    ispis += "<br/><br/>";
                }
                $('#objave_objavepage').html(ispis);


                var sveStraniceLinkovi = document.getElementsByClassName('straniceLinkAjax');
                for(let i=0; i<sveStraniceLinkovi.length; i++)
                {
                    if(sveStraniceLinkovi[i].innerHTML == kojaStranica){
                        sveStraniceLinkovi[i].style.border = "1px solid #7971ea";
                        sveStraniceLinkovi[i].style.borderRadius = "5px";
                    }
                }
            }

        },
        error : function (xhr, status, error) {

        }
    });
}