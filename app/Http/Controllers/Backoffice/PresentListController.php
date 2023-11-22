<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\PresentListContract;
use App\Http\Controllers\Controller;
use App\Repositories\PresentListRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresentListController extends Controller
{
    private PresentListContract $presentRepo;
    public function __construct()
    {
        $this->presentRepo = new PresentListRepository;
    }

    public function index()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $result = $this->presentRepo->getAllPayload(['start_date' => $firstDayOfMonth, 'end_date' => $lastDayOfMonth]);
        return view('Pages.Presents')->with('list', $result);
    }

    public function getAllData(array $request) {
        $result = $this->presentRepo->getAllPayload($request);

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
