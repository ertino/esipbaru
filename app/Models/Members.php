<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
|--------------------------------------------------------------------------
| Members
|--------------------------------------------------------------------------
|
| Legacy user model used by App\Http\Controllers\Auth\AuthController (the
| pre-Breeze authentication flow). The class was referenced by that
| controller in ijinnakes but was not part of the shipped source tree.
|
| The table name ("members") is inferred from the validation rule
| "unique:members" and from the column usage in AuthController
| (email, no_telepon, password, google_id, status, email_verified_at).
| Adjust $table/$fillable if the production schema differs.
|
*/

class Members extends Authenticatable
{
    use Notifiable;

    protected $table = 'members';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}