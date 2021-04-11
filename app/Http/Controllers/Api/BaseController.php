<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
  protected $http_responses = [
    201 => ['created' => 'Запись создана'],
    204 => ['deleted' => 'Запись удалена'],
    404 => ['not_found' => 'Запись не найдена'],
  ];
}
