<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SatuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nama" => ["required", "string"],
            "user" => ["required", "string"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user' => Auth::user()->name,
        ]);
    }
}
