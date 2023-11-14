<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\RuleContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\RuleRequest;
use App\Repositories\RuleRepository;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    private RuleContract $ruleRepo;
    public function __construct()
    {
        $this->ruleRepo = new RuleRepository;
    }

    public function getAllData()
    {
        $result = $this->ruleRepo->getAllPayload([]);

        return response()->json($result, $result['code']);
    }

    public function getDataById(int $id)
    {
        $result = $this->ruleRepo->getPayloadById($id);

        return response()->json($result, $result['code']);
    }

    public function upsertData(RuleRequest $request)
    {
        $id = $request->id | null;
        $result = $this->ruleRepo->upsertPayload($id, $request->all());

        return response()->json($result, $result['code']);
    }

    public function deleteData(int $id)
    {
        $result = $this->ruleRepo->deletePayload($id);
        return response()->json($result, $result['code']);
    }
}
