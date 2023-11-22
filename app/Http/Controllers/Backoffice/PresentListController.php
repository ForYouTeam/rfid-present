<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\PresentListContract;
use App\Http\Controllers\Controller;
use App\Repositories\PresentListRepository;
use Illuminate\Http\Request;

class PresentListController extends Controller
{
    private PresentListContract $presentRepo;
    public function __construct()
    {
        $this->presentRepo = new PresentListRepository;
    }

    public function getAllData(Request $request) {
        $result = $this->presentRepo->getAllPayload($request->all());

        return response()->json($result, $result['code']);
    }

    public function setPresentData() {
        $payload = [
            'rfid' => request('rfid') ?? 0
        ];

        $result = $this->presentRepo->setPresentTime($payload);
        return response()->json($result, $result['code']);
    }
}
