<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetLozinkeEmailProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "email" => "required|regex:/^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/|exists:korisnik,email"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Polje za email mora biti popunjeno",
            "email.regex" => "Email nije u dobrom formatu",
            "email.exists" => "Ne postoji nalog sa unetim email-om"
        ];
    }
}
