<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactProveraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "contactEmail" => "required|regex:/^[\w\d]+[\.\_\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/",
            "poruka" => "required|between:15,500"
        ];
    }

    public function messages()
    {
        return [
            "contactEmail.required" => "Polje za email mora biti popunjeno",
            "contactEmail.regex" => "Email nije u dobrom formatu",
            "poruka.required" => "Polje za poruku mora biti popunjeno",
            "poruka.between" => "Poruka mora imati 15-500 karaktera"
        ];
    }
}
