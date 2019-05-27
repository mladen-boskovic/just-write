<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "regIme" => "required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/",
            "regPrezime" => "required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/",
            "regEmail" => "required|regex:/^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/",
            "regKorIme" => "required|regex:/^[\w\d\.\_]{5,15}$/",
            "regSlika" => "nullable|image|mimes:jpeg,jpg,png,bmp,gif,svg|max:2048",
            "add_aktivan" => "lt:2",
            "add_uloga" => "gt:0"
        ];
    }

    public function messages()
    {
        return [
            "regIme.required" => "Polje za ime mora biti popunjeno",
            "regIme.regex" => "Ime nije u dobrom formatu",
            "regPrezime.required" => "Polje za prezime mora biti popunjeno",
            "regPrezime.regex" => "Prezime nije u dobrom formatu",
            "regEmail.required" => "Polje za email mora biti popunjeno",
            "regEmail.regex" => "Email nije u dobrom formatu",
            "regKorIme.required" => "Polje za korisničko ime mora biti popunjeno",
            "regKorIme.regex" => "Korisničko ime mora imati 5-15 karaktera. Sme da sadrži slova, brojeve, tačku i donju crtu",
            "regSlika.max" => "Slika ne sme biti veća od 2048KB",
            "regSlika.mimes" => "Slika mora biti jpeg, jpg, png, bmp, gif ili svg formata",
            "regSlika.image" => "Loš format, morate dodati sliku",
            "add_aktivan.lt" => "Morate odabrati aktivnost korisnika",
            "add_uloga.gt" => "Morate odabrati ulogu"
        ];
    }
}
