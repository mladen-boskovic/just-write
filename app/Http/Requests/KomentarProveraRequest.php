<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomentarProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "komentar" => "required|between:2,300"
        ];
    }

    public function messages()
    {
        return [
            "komentar.required" => "Polje za komentar mora biti popunjeno",
            "komentar.between" => "Komentar mora imati 2-300 karaktera"
        ];
    }
}
