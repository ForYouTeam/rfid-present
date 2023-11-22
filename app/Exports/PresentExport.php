<?php

namespace App\Exports;

use App\Models\Present_lists;
use App\Repositories\PresentListRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PresentExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(protected Request $request)
    {
    }

    public function view(): View
    {
      $presentRepo = (new PresentListRepository())->getAllPayload($this->request->all());
        
        return view('Export.PresentList', [
          'data' => $presentRepo['data'],
          'dateRange' => $this->request->all(),
        ]);
    }
}
