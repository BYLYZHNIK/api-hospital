<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SyncController extends BaseController
{
  public function user(Request $request)
  {
    $user = auth()->user();
//    $user->load('company');
    return compact('user');
  }
}
