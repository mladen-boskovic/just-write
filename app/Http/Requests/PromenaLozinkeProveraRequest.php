<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromenaLozinkeProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "trenutnaLozinka" => "required|min:6",
            "novaLozinka" => "required|min:6|same:novaLozinka2",
            "novaLozinka2" => "required|min:6"
        ];
    }

    public function messages()
    {
        return [
            "trenutnaLozinka.required" => "Polje za trenutnu lozinku mora biti popunjeno",
            "trenutnaLozinka.min" => "Trenutna lozinka mora imati bar 6 karaktera",
            "novaLozinka.required" => "Polje za novu lozinku mora biti popunjeno",
            "novaLozinka.min" => "Nova lozinka mora imati bar 6 karaktera",
            "novaLozinka.same" => "Nova lozinka i ponovljena lozinka se ne poklapaju",
            "novaLozinka2.required" => "Polje za ponovljenu lozinku mora biti popunjeno",
            "novaLozinka2.min" => "Ponovljena lozinka mora imati bar 6 karaktera",
        ];
    }
}
