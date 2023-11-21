<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\EmployeContract;
use App\Contracts\PositionContract;
use App\Contracts\SatkerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeRequest;
use App\Repositories\EmployeRepository;
use App\Repositories\PositionRepository;
use App\Repositories\SatkerRepository;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    private EmployeContract $employeRepo;
    private PositionContract $positionRepo;
    private SatkerContract $satkerRepo;
    public function __construct()
    {
        $this->employeRepo = new EmployeRepository;
        $this->positionRepo = new PositionRepository;
        $this->satkerRepo = new SatkerRepository;
    }

    public function index()
    {
        $position = $this->positionRepo->getAllPayload([]);
        $satker   = $this->satkerRepo->getAllPayload([]);

        $employe          = $this->employeRepo->getAllPayload([]);
        $result['data']   = collect($employe['data'])->map(function ($item) {
            return [
                'id'          => $item->id,
                'rfid'        => $item->rfid,
                'name'        => $item->name,
                'nirp'        => $item->nirp,
                'nik'         => $item->nik,
                'sex'         => $item->sex,
                'position_id' => $item->position_id,
                'position'    => $item->position,
                'satker_id'   => $item->satker_id,
                'satker'      => $item->satker,
                'created_at'  => $item->created_at,
            ];
        });

        $result['position'] = collect($position['data'])->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
        $result['satker'] = collect($satker['data'])->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });

        return view('Pages.Employes')->with('list', $result);
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
