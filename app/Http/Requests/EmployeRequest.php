<?php

namespace App\Http\Requests;

use App\Rules\UniqueExceptCurrent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'rfid'        => ['required', 'max:20'],
            'nirp'        => ['required', 'max:20'],
            'nik'         => ['required', 'max:20'],
            'name'        => ['required', 'max:250'],
            'sex'         => ['required', 'max:250'],
            'position_id' => ['required'],
            'satker_id'   => ['required'],
            // ... tambahkan aturan validasi lainnya
        ];

        // Cek keberadaan id dalam request
        if (!$this->has('id') || !$this->input('id')) {
            $id = $this->input('id');
            $rules['rfid'       ][] = new UniqueExceptCurrent('employes', 'rfid'       , $this->input('rfid'       ), 'id', $id);
            $rules['nirp'       ][] = new UniqueExceptCurrent('employes', 'nirp'       , $this->input('nirp'       ), 'id', $id);
            $rules['nik'        ][] = new UniqueExceptCurrent('employes', 'nik'        , $this->input('nik'        ), 'id', $id);
            // ... tambahkan aturan validasi lainnya yang perlu diterapkan saat mengedit
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
