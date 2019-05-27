<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KategorijaProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "addKategorija" => "required|between:2,20"
        ];
    }

    public function messages()
    {
        return [
            "addKategorija.required" => "Polje za naziv mora biti popunjeno",
            "addKategorija.between" => "Naziv mora imati 2-20 karaktera"
        ];
    }
}
