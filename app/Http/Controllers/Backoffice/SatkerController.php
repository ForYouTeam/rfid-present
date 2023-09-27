<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\SatkerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\SatkerRequest;
use App\Repositories\SatkerRepository;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    private SatkerContract $positionRepo;
    public function __construct()
    {
        $this->positionRepo = new SatkerRepository;
    }

    public function getAllData()
    {
        $result = $this->positionRepo->getAllPayload([]);

        return response()->json($result, $result['code']);
    }

    public function getDataById(int $id)
    {
        $result = $this->positionRepo->getPayloadById($id);

        return response()->json($result, $result['code']);
    }

    public function upsertData(SatkerRequest $request)
    {
        $id = $request->id | null;
        $result = $this->positionRepo->upsertPayload($id, $request->all());

        return response()->json($result, $result['code']);
    }

    public function deleteData(int $id)
    {
        $result = $this->positionRepo->deletePayload($id);
        return response()->json($result, $result['code']);
    }
}
