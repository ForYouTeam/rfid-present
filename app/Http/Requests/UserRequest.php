<?php

namespace App\Http\Requests;

use App\Rules\UniqueExceptCurrent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:150'],
            'scope' => ['required', 'max:25'],
            'username' => ['required', 'max:50', 'min:5'],
            'password' => ['required', 'max:20', 'min:5', 'confirmed'],
            // ... tambahkan aturan validasi lainnya
        ];

        // Cek keberadaan id dalam request
        if (!$this->has('id')) {
            $id = $this->input('id');
            $rules['username'][] = new UniqueExceptCurrent('users', 'username', $this->input('username'), 'id', $id);
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'response' => array(
                'icon' => 'error',
                'title' => 'Validasi Gagal',
                'message' => 'Data yang di input tidak tervalidasi',
            ),
            'errors' => array(
                'length' => count($validator->errors()),
                'data' => $validator->errors()
            ),
        ], 422));
    }
}
