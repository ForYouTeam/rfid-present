<?php

namespace App\Http\Requests;

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
        return [
            'rfid'        => 'required|max:20|unique_except_current:employes,rfid,' . $this->route('employe'),
            'name'        => 'required|max:150',
            'nirp'        => 'required|max:20|unique_except_current:employes,nirp,' . $this->route('employe'),
            'nik'         => 'required|max:20|unique_except_current:employes,nik,' . $this->route('employe'),
            'sex'         => 'required|max:20',
            'position_id' => 'required',
            'satker_id'   => 'required',
            'kls'         => 'required|max:150'
        ];
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
