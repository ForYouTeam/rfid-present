<?php

namespace App\Repositories;

use App\Contracts\PositionContract;
use App\Models\Positions;
use App\Traits\HttpResponseModel;
use Carbon\Carbon;

class PositionRepository implements PositionContract
{
  use HttpResponseModel;

  private Positions $positionModel;
  public function __construct()
  {
    $this->positionModel = new Positions();
  }
  public function getAllPayload(array $payload)
  {
    try {
      $data = $this->positionModel->all();
      return $this->success($data, "success getting data");

    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
  }

  public function getPayloadById(int $id)
  {
    try {     
      $find = $this->positionModel->whereId($id)->first();

      if (!$find) {
        return $this->error('data not found', 404);
      }
      return $this->success($find, "success getting data");

    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
  }

  public function upsertPayload($id, array $payload)
  {
    try {
      $now = Carbon::now();
      if ($id) {
        $find = $this->getPayloadById($id);
        if ($find['code'] !== 200) {
          return $find;
        }

        $payload['updated_at'] = $now; 
        $result = [
          'data' => $this->positionModel->whereId($id)->update($payload),
          'message' => 'Updated data successfully'
        ];
        
      } else {
        $payload['created_at'] = $now;
        $payload['updated_at'] = $now;
        $result = [
          'data' => $this->positionModel->create($payload),
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
      $data = $this->positionModel->whereId($id)->delete();
      return $this->success($data, "success deleting data");

    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
  }
}