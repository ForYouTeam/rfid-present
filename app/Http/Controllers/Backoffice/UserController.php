<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserContract $userRepo;
    public function __construct()
    {
        $this->userRepo = new UserRepository;
    }

    public function getAllData()
    {
        $result = $this->userRepo->getAllPayload([]);

        return response()->json($result, $result['code']);
    }

    public function getDataById(int $id)
    {
        $result = $this->userRepo->getPayloadById($id);

        return response()->json($result, $result['code']);
    }

    public function upsertData(UserRequest $request)
    {
        $id = $request->id | null;
        $result = $this->userRepo->upsertPayload($id, $request->all());

        return response()->json($result, $result['code']);
    }

    public function deleteData(int $id)
    {
        $result = $this->userRepo->deletePayload($id);
        return response()->json($result, $result['code']);
    }
}
