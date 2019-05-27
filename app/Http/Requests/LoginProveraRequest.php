<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "loginKorIme" => "required|regex:/^[\w\d\.\_]{5,15}$/",
            "loginLozinka" => "required|min:6"
        ];
    }

    public function messages()
    {
        return [
            "loginKorIme.required" => "Polje za korisničko ime mora biti popunjeno",
            "loginKorIme.regex" => "Korisničko ime mora imati 5-15 karaktera. Sme da sadrži slova, brojeve, tačku i donju crtu",
            "loginLozinka.required" => "Polje za lozinku mora biti popunjeno",
            "loginLozinka.min" => "Lozinka mora imati bar 6 karaktera"
        ];
    }
}
