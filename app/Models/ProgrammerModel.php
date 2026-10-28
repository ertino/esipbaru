<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProgrammerModel extends Model
{
    public function getdatatask($posting){

        $user_id = $posting->user_id;

        if ($user_id == '') {
            return DB::table('tbl_task')
            ->select(DB::raw('id, start_date as start, end_date as end, allDay, remark as title, case when status_task = "0" then "#e6845d" when status_task = "1" then "#00d4b9" when status_task = "2" then "#c9604a" else "#9c1b0c" end as color'))
            ->where('status_task','<>','3')
            ->orderBy('id', 'asc')
            ->get();

        } else {
            return DB::table('tbl_task')
            ->select(DB::raw('id, start_date as start, end_date as end, allDay, remark as title, case when status_task = "0" then "#e6845d" when status_task = "1" then "#00d4b9" when status_task = "2" then "#c9604a" else "#9c1b0c" end as color'))
            ->where('status_task','<>','3')
            ->whereRaw('app_id in (select distinct id from tbl_apps where pic_ = "'.$user_id.'")')
            ->orderBy('id', 'asc')
            ->get();

        }
        
    }

    public function getTimeline($user_id)
    {

        $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url')
            ->orderBy('id');
        

        return DB::table('tbl_activity')
            ->select(DB::raw('tbl_activity.activity_id, tbl_activity.activity, tbl_activity.jenis, tbl_activity.timestamp, s0.name, s0.photo_url'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_activity.user_id', 's0.id');
            })
            ->where('user_id', '=', $user_id)
            ->limit(8)
            ->orderby('tbl_activity.timestamp', 'desc')
            ->get();
    }




}
