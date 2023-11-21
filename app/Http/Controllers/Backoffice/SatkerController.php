<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\SatkerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\SatkerRequest;
use App\Repositories\SatkerRepository;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    private SatkerContract $satkerRepo;
    public function __construct()
    {
        $this->satkerRepo = new SatkerRepository;
    }

    public function index()
    {
        $result = $this->satkerRepo->getAllPayload([]);
        $result = collect($result['data'])->map(function ($item) {
            return [
                'id'          => $item->id,
                'name'        => $item->name,
                'description' => $item->description,
                'created_at'  => $item->created_at,
            ];
        });
        return view('Pages.Satker')->with('list', $result);
    }

    public function getAllData()
    {
        $result = $this->satkerRepo->getAllPayload([]);

        return response()->json($result, $result['code']);
    }

    public function getDataById(int $id)
    {
        $result = $this->satkerRepo->getPayloadById($id);

        return response()->json($result, $result['code']);
    }

    public function upsertData(SatkerRequest $request)
    {
        $id = $request->id | null;
        $result = $this->satkerRepo->upsertPayload($id, $request->all());

        return response()->json($result, $result['code']);
    }

    public function deleteData(int $id)
    {
        $result = $this->satkerRepo->deletePayload($id);
        return response()->json($result, $result['code']);
    }
}
