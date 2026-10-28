<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| TrMessages
|--------------------------------------------------------------------------
|
| Legacy WhatsApp message log used by App\Http\Controllers\Auth\AuthController.
| Referenced in ijinnakes but not shipped with the source tree. The table name
| ("tr_messages") and columns (phone, members_id) are inferred from that usage.
|
*/

class TrMessages extends Model
{
    protected $table = 'tr_messages';

    protected $guarded = [];
}