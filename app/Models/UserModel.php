<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
  public function GetUser($username, $password)
  {
    return DB::table('users')
      ->select('id', 'username')
      ->where('username', $username)
      ->where('password', $password)
      ->first();
  }

  public function SimpanUser($data)
  {
    return DB::table('users')
      ->insertGetId($data);
  }
}
