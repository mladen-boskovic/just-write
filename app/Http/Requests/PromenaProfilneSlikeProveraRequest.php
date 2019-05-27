<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromenaProfilneSlikeProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "profilnaSlika" => "required|image|mimes:jpeg,jpg,png,bmp,gif,svg|max:2048"
        ];
    }

    public function messages()
    {
        return [
            "profilnaSlika.required" => "Morate odabrati sliku",
            "profilnaSlika.max" => "Slika ne sme biti veća od 2048KB",
            "profilnaSlika.mimes" => "Slika mora biti jpeg, jpg, png, bmp, gif ili svg formata",
            "profilnaSlika.image" => "Loš format, morate dodati sliku"
        ];
    }
}
