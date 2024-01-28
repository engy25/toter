<?php
namespace App\Services;

use App\Models\StatusTranslation;
class StatusService
{

  public function getStatusIdByName($name)
  {
      return StatusTranslation::where("name", $name)->value("status_id");
  }
}

