<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\PositionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private PositionContract $positionRepo;
    public function __construct()
    {
        $this->positionRepo = new PositionRepository;
    }

    public function index()
    {
        $result = $this->positionRepo->getAllPayload([]);
        $result = collect($result['data'])->map(function ($item) {
            return [
                'id'          => $item->id,
                'name'        => $item->name,
                'description' => $item->description,
                'created_at'  => $item->created_at,
            ];
        });
        return view('Pages.Position')->with('list', $result);
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

    public function upsertData(PositionRequest $request)
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
