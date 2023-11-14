<?php

namespace App\Contracts;

interface PresentListContract
{
  public function getAllPayload(array $payload);
  public function getAvailability(string $payload);
  public function getByTime(string $payload, string $type);
  public function getEmployeByRfid(string $payload);
  public function getPresentRules(string $payload);
  public function setPresentTime(array $payload);
}