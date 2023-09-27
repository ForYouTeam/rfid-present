<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\EmployeContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeRequest;
use App\Repositories\EmployeRepository;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    private EmployeContract $employeRepo;
    public function __construct()
    {
        $this->employeRepo = new EmployeRepository;
    }

    public function getAllData()
    {
        $result = $this->employeRepo->getAllPayload([]);

        return response()->json($result, $result['code']);
    }

    public function getDataById(int $id)
    {
        $result = $this->employeRepo->getPayloadById($id);

        return response()->json($result, $result['code']);
    }

    public function upsertData(EmployeRequest $request)
    {
        $id = $request->id | null;
        $result = $this->employeRepo->upsertPayload($id, $request->all());

        return response()->json($result, $result['code']);
    }

    public function deleteData(int $id)
    {
        $result = $this->employeRepo->deletePayload($id);
        return response()->json($result, $result['code']);
    }
}
