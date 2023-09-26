<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;
use App\Traits\HttpResponseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserContract
{
  use HttpResponseModel;

  private User $userModel;
  public function __construct()
  {
    $this->userModel = new User();
  }
  public function getAllPayload(array $payload)
  {
    try {

      $data = $this->userModel->where('scope', 'admin')->orWhere('scope', 'user')->all();

      return $this->success($data, "success getting data");

    } catch (\Throwable $th) {

      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );
    }
  }

  public function getPayloadById(int $id)
  {
    try {
      
      $find = $this->userModel->whereId($id)->first();

      if (!$find) {
        return $this->error('user not found', 404);
      }

      return $this->success($find, "success getting data");

    } catch (\Throwable $th) {

      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );
    }
  }

  public function upsertPayload($id, array $payload)
  {
    try {
      
      $payload['password'] = Hash::make($payload['password']);

      if ($id) {

        $find = $this->getPayloadById($id);

        if ($find['code'] !== 200) {
          return $find;
        }

        $payload['updated_at'] = Carbon::now();

        $result = [
          'data' => $this->userModel->whereId($id)->update($payload),
          'message' => 'Updated data successfully'
        ];

      } else {

        $result = [
          'data' => $this->userModel->create($payload),
          'message' => 'Created data successfully'
        ];

      }

      return $this->success($result['data'], $result['message']);

    } catch (\Throwable $th) {
      
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );
    }
  }

  public function deletePayload(int $id)
  {
    try {

      $find = $this->getPayloadById($id);

      if ($find['code'] != 200) {
        return $find;
      }

      if ($find['code'] == 200 && $find['data']['scope'] == 'super-admin') {
        return $this->error('user not found', 404);
      }

      $data = $this->userModel->whereId($id)->delete();

      return $this->success($data, "success deleting data");

    } catch (\Throwable $th) {

      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );
    }
  }
}