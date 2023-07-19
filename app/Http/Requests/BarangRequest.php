<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BarangRequest extends FormRequest
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
            "barcode" => ["nullable", "string"],
            "nama" => ["required", "string"],
            "satuan_id" => ["required", "exists:satuans,id"],
            "stok_min" => ["numeric", "string"],
            "stok" => ["numeric", "string"],
            "stok_awal" => ["numeric", "string"],
            "harga_jual" => ["required", "string"],
            "keterangan" => ["required", "string"],
            "user" => ["required", "string"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user' => Auth::user()->name,
            'stok_awal' => $this->stok,
            'harga_jual' =>  str_replace(',', '', $this->harga_jual),
        ]);
    }
}
