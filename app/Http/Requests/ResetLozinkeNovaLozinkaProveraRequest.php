<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetLozinkeNovaLozinkaProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "novaLozinka" => "required|min:6|same:novaLozinka2",
            "novaLozinka2" => "required|min:6"
        ];
    }

    public function messages()
    {
        return [
            "novaLozinka.required" => "Polje za novu lozinku mora biti popunjeno",
            "novaLozinka.min" => "Nova lozinka mora imati bar 6 karaktera",
            "novaLozinka2.min" => "Ponovljena lozinka mora imati bar 6 karaktera",
            "novaLozinka.same" => "Nova lozinka i ponovljena lozinka se ne poklapaju",
            "novaLozinka2.required" => "Polje za ponovljenu lozinku mora biti popunjeno"
        ];
    }
}
