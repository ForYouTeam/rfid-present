<?php

namespace App\Repositories;

use App\Contracts\RuleContract;
use App\Models\Rules;
use App\Traits\HttpResponseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RuleRepository implements RuleContract
{
  use HttpResponseModel;

  private Rules $ruleModel;
  public function __construct()
  {
    $this->ruleModel = new Rules();
  }
  public function getAllPayload(array $payload)
  {
    try {
      $data = $this->ruleModel->all();
      return $this->success($data, "success getting data");

    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
  }

  public function getPayloadById(int $id)
  {
    try {     
      $find = $this->ruleModel->whereId($id)->first();

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
      DB::beginTransaction();
      
      $resultData = [];
      foreach ($payload as $value) {
        if ($value['id'] ?? null) {
          $find = $this->getPayloadById($value['id']);
          if ($find['code'] !== 200) {
            return $find;
          }
  
          $payload['updated_at'] = $now; 
          $result = [
            'data' => $this->ruleModel->whereId($value['id'])->update($value),
            'message' => 'Updated data successfully'
          ];
          
        } else {
          $payload['created_at'] = $now;
          $payload['updated_at'] = $now;
          $result = [
            'data' => $this->ruleModel->create($value),
            'message' => 'Created data successfully'
          ];
  
        }
        array_push($resultData, $result);
      }

      DB::commit();
    } catch (\Throwable $th) {    
      DB::rollBack();
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
    return $this->success($resultData, 'Created data successfully');
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
      $data = $this->ruleModel->whereId($id)->delete();
      return $this->success($data, "success deleting data");

    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__ );

    }
  }
}