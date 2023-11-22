<?php

namespace App\Repositories;

use App\Contracts\PresentListContract;
use App\Models\Employes;
use App\Models\Present_lists;
use App\Models\Rules;
use App\Traits\HttpResponseModel;
use Carbon\Carbon;

class PresentListRepository implements PresentListContract
{
  use HttpResponseModel;

  private Present_lists $presentModel;
  private Employes $employeModel;
  public function __construct()
  {
    $this->presentModel = new Present_lists;
    $this->employeModel = new Employes;
  }

  public function getAllPayload(array $payload)
  {
    try {
      $data = $this->presentModel
      ->whereDate('present_lists.created_at', '>=', $payload['start_date'])
      ->whereDate('present_lists.created_at', '<=', $payload['end_date'])
      ->withRelation();
      
      $uniqData = $data
        ->clone()
        ->distinct()
        ->get();

      $maps = collect($uniqData)
        ->map(function ($item) use ($data) {
            $employe = $data
              ->clone()
              ->where('m1.rfid', $item['employe_rfid']);

            $hadir = $employe
              ->clone()
              ->whereNotNull('present_lists.start_in')
              ->whereNotNull('present_lists.start_out')
              ->where('present_lists.description', 'NOT LIKE', '%lambat%');;

            $bolos = $employe
              ->clone()
              ->whereNotNull('present_lists.start_in')
              ->whereNull('present_lists.start_out')
              ->orWhere('present_lists.description', 'LIKE', '%lambat%');

            return [
              "id"           => $item['id'],
              "present_date" => $item['present_date'],
              "employe_rfid" => $item['employe_rfid'],
              "employe_name" => $item['employe_name'],
              "description"  => $item['description'],
              "summary"      => [
                "hadir" => $hadir->select('present_lists.present_date')->get()->toArray(),
                "bolos" => $bolos->select('present_lists.present_date')->get()->toArray()
              ],
            ];
        });

      return $this->success($maps, "success getting data");
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }

  public function getAvailability(string $payload)
  {
    try {
      $date = Carbon::now()->toDateString();

      $findStartTime = $this->presentModel->withRelation()->where('m1.rfid', $payload)->whereDate('present_lists.created_at', $date)->whereNotNull('start_in')->first();
      $findEndTime = $this->presentModel->withRelation()->where('m1.rfid', $payload)->whereDate('present_lists.created_at', $date)->whereNotNull('start_out')->first();

      $data = [
        "start"  => $findStartTime,
        "end"    => $findEndTime,
        "status" => $findStartTime->status ?? ''
      ];

      return $this->success($data, "success getting data");
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }

  public function getByTime(string $payload, string $type)
  {
    try {
      $data = $this->presentModel->withRelation()->whereTime($type, $payload);
      return $this->success($data, "success getting data");
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }

  public function getEmployeByRfid(string $payload)
  {
    try {
      $data = $this->employeModel->withRelation()->where('employes.rfid', $payload)->first();
      if (!$data) {
        return $this->error('employee not found', 404);
      }

      return $this->success($data, "success getting data");
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }

  public function getPresentRules($payload)
  {
    try {
      $date = Carbon::now('Asia/Singapore');
      $presentRules = Rules::where('type', 'max_present')->where('tag', $payload)->first();

      if ($presentRules->count() >= 1) {
        if ($payload === 'ms') {
          $result = $date->format('H:i') < Carbon::createFromFormat('H:i', $presentRules['value'])->format('H:i');
          return $this->success($result, "success getting data");
        } else {
          $result = $date->format('H:i') > Carbon::createFromFormat('H:i', $presentRules['value'])->format('H:i');
          return $this->success($result, "success getting data");
        }
      }

      return false;
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }

  public function setPresentTime(array $payload)
  {
    try {
      $date  = new Carbon;

      $findRfidData = $this->getAvailability($payload['rfid']);

      $startTimeRules = Rules::where('tag', 's_time')->select('value')->first();
      $endTimeRules   = Rules::where('tag', 'e_time')->select('value')->first();

      if ($findRfidData['code'] !== 200) {
        return $findRfidData;
      }

      // Jika sudah melakukan absen masuk dan pulang
      if ($findRfidData['data']['start'] && $findRfidData['data']['end']) {
        return $this->error('present has full time', 422);
      }

      // Jika sudah melakukan absen masuk
      if ($findRfidData['data']['start']) {
        $rulesMe = $this->getPresentRules('me');

        if ($rulesMe['code'] !== 200) {
          return $rulesMe;
        }

        if ($rulesMe['data']) {
          return $this->error("time has not yet been recorded", 422);
        }

        $status = ($date->toTimeString() < $endTimeRules['value']) ? 'bolos' : 'tepat';

        $data = [
          'start_out'   => $date->toTimeString(),
          'status'      => $status,
          'description' => $findRfidData['data']['status'] . ',' . $status,
          'updated_at'  => $date->now()
        ];

        $result = $this->presentModel->whereId($findRfidData['data']['start']['id'])->update($data);
      }

      if (!$findRfidData['data']['start']) {
        $rulesMe = $this->getPresentRules('ms');

        if ($rulesMe['code'] !== 200) {
          return $rulesMe;
        }

        if ($rulesMe['data']) {
          return $this->error("time has not yet been recorded", 422);
        }

        $employe = $this->getEmployeByRfid($payload['rfid']);

        if ($employe['code'] !== 200) {
          return $employe;
        }

        // dd($date->toTimeString());
        $status = ($date->toTimeString() >= $startTimeRules['value']) ? 'lambat' : 'tepat';

        $data = [
          'present_date' => $date->toDateTimeString(),
          'start_in'     => $date->toTimeString(),
          'employe_id'   => $employe['data']['id'],
          'status'       => $status,
          'description'  => $status,
          'grouping_by'  => $employe['data']['satker_id']
        ];

        $result = $this->presentModel->create($data);
      }

      return $this->success($result, "success set present");
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), 500, $th, class_basename($this), __FUNCTION__);
    }
  }
}
