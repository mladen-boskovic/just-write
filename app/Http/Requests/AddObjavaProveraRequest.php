<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddObjavaProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "addObjavaNaslov" => "required|between:15,100",
            "addObjavaTekst" => "required|between:100,1000",
            "addObjavaKategorija" => "gt:0",
            "addObjavaSlika" => "required|image|mimes:jpeg,jpg,png,bmp,gif,svg|max:2048"
        ];
    }

    public function messages()
    {
        return [
            "addObjavaNaslov.required" => "Polje za naslov mora biti popunjeno",
            "addObjavaNaslov.between" => "Naslov mora imati 15-100 karaktera",
            "addObjavaTekst.required" => "Polje za tekst mora biti popunjeno",
            "addObjavaTekst.between" => "Tekst mora imati 100-1000 karaktera",
            "addObjavaKategorija.gt" => "Morate odabrati kategoriju",
            "addObjavaSlika.required" => "Morate odabrati sliku",
            "addObjavaSlika.max" => "Slika ne sme biti veća od 2048KB",
            "addObjavaSlika.mimes" => "Slika mora biti jpeg, jpg, png, bmp, gif ili svg formata",
            "addObjavaSlika.image" => "Loš format, morate dodati sliku"
        ];
    }
}
