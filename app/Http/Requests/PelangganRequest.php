<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "nama" => ["required", "string"],
            "alamat" => ["required", "string"],
            "kontak" => ["required", "string"],
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
