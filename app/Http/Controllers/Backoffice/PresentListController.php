<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\PresentListContract;
use App\Exports\PresentExport;
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

    public function downloadReport(Request $request) {
        return (new PresentExport($request))->download('presentList.xlsx');
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
