<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\CarbonPeriod;

class SchedulerModel extends Model
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

    public function setkadaluarsa() {

        $now = date('Y-m-d H:i:s');

        $getallset = DB::table('tbl_docs')
            ->where('expiring_count', '0')
            ->get();

        foreach($getallset as $toset) {

            DB::table('tbl_docs')
                ->where('id', $toset->id)
                ->update([
                    'kadaluarsa' => '1',
                    'updated_at' => $now
                ]);

            DB::table('tbl_pengajuan')
                ->where('id_doc', $toset->id)
                ->update([
                    'isApproved' => 'K',
                    'updater' => 'SYSTEM',
                    'updated_at' => $now
                ]);
            
            DB::table('tbl_sip')
                ->where('id_doc', $toset->id)
                ->update([
                    'status_sip' => 'K',
                    'updated_at' => $now
                ]);

            DB::table('tbl_jadwalpraktik')
                ->where('id_doc', $toset->id)
                ->update([
                    'kadaluarsa' => '1',
                    'remark' => 'STR Kadaluarsa',
                    'updated_at' => $now
                ]);

            DB::table('approved_jadwal')
                ->where('id_doc', $toset->id)
                ->update([
                    'kadaluarsa' => '1',
                    'remark' => 'STR Kadaluarsa',
                    'updated_at' => $now
                ]);

        }

        return true;

    }

    public function queuelist() {

    
        $s0 = DB::table('tbl_pendaftaran')
            ->select('id_user as id_nakes', 'notelp');

        return DB::table('tbl_information')
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_information.terupdate', 's0.id_nakes');
            })
            ->where('notif_send', '0')
            ->orderBy('id')
            ->first();

    }

    public function updateinfo($id_info, $now, $statussend) {

        return DB::table('tbl_information')
                    ->where('id', $id_info)
                    ->update([
                        'notif_send' => $statussend,
                        'sent_at' => $now
                    ]);

    }

    public function detailrekappelayanan($year) {

        $data = DB::select("CALL GetSipDataByYearSum(?)", [$year]);

        $totalPengajuan = 0;

        foreach ($data as $record) {
           
            $totalPengajuan += $record->total + $record->terlambat;
          
        }

        // Return the result in the required format
        return [
            "periode" => $year,
            "total_pengajuan" => $totalPengajuan,
        ];

    }

    private function getTimeOfDay($hour)
    {
        $hour = intval(Str::before($hour, ':'));
        if ($hour < 10) return 'pagi';
        if ($hour < 15) return 'siang';
        if ($hour < 19) return 'sore';
        return 'malam';
    }

    private function getTimeBlocks($day, $start, $end)
    {
        $blocks = [];
        $period = CarbonPeriod::create($start, '1 hour', $end);
        foreach ($period as $time) {
            $hour = $time->format('H:i');
            $blocks[] = [
                'hari' => $day,
                'jam' => $hour,
                'sebutan_waktu' => $this->getTimeOfDay($hour)
            ];
        }
        return $blocks;
    }

    public function getallnakes()
    {
        $s0 = DB::table('tbl_sip')
            ->select('id_doc', 'id_pengajuan', 'id_nakes as id_user', 'nama_nakes', 'nama_faskes', 'nama_lokasi', 'valid_until', 'kompetensi', 'profesi', 'salinan', 'perubahan', 'kec_lokasi')
            ->where('status_sip', '1');

        $query =  DB::table('approved_jadwal')
            ->select('s0.id_doc', 's0.id_pengajuan', 's0.id_user', 's0.nama_nakes', 's0.nama_faskes', 's0.nama_lokasi', 's0.valid_until', 's0.kompetensi', 's0.salinan', 'detail_jadwal', 's0.kec_lokasi')
            ->joinsub($s0, 's0', function($join){
                $join->on('approved_jadwal.id_pengajuan', 's0.id_pengajuan')->on('approved_jadwal.id_user', 's0.id_user')->on('approved_jadwal.id_doc', 's0.id_doc')->on ('approved_jadwal.salinan', 's0.salinan')->on('approved_jadwal.perubahan', 's0.perubahan');
            })
            ->wherenotnull('s0.valid_until')
            ->orderby('s0.id_user')
            ->limit(200)
            ->get();
        
        $grouped = collect($query)->groupBy('nama_nakes')->map(function ($nakesGroup) {
            $first = $nakesGroup->first();

            $praktik = $nakesGroup->map(function ($row) {
                $jadwalJson = $row->detail_jadwal;
                $jadwal = collect();
                $hariList = [];
                $jamList = [];
                $timeBlocks = [];

                if (!empty($jadwalJson)) {
                    $decoded = json_decode($jadwalJson);
                    if (is_array($decoded)) {
                        $jadwal = collect($decoded)->map(function ($item) use (&$hariList, &$jamList, &$timeBlocks) {
                            $hari = $item->hari ?? null;
                            $waktu = $item->pukul ?? null;

                            $start = $end = null;
                            $timeOfDay = [];

                            if ($waktu && Str::contains($waktu, '-')) {
                                [$start, $end] = array_map('trim', explode('-', $waktu));
                                $jamList[] = $start;
                                $jamList[] = $end;

                                $timeOfDay[] = $this->getTimeOfDay($start);
                                $timeOfDay[] = $this->getTimeOfDay($end);

                                $blocks = $this->getTimeBlocks($hari, $start, $end);
                                $timeBlocks = array_merge($timeBlocks, $blocks);
                            }

                            if ($hari) {
                                $hariList[] = $hari;
                            }

                            return [
                                'hari' => $hari,
                                'waktu' => $waktu,
                                'waktu_mulai' => $start,
                                'waktu_berakhir' => $end,
                                'sebutan_waktu' => array_unique($timeOfDay),
                                'keterangan' => $item->uraian ?? null,
                            ];
                        });
                    }
                }

                return [
                    'faskes' => $row->nama_faskes,
                    'lokasi' => $row->nama_lokasi,
                    'kecamatan' => $row->kec_lokasi,
                    'jadwal' => $jadwal->values(),
                    'hari_list' => array_values(array_unique($hariList)),
                    'jam_list' => array_values(array_unique($jamList)),
                    'time_blocks' => $timeBlocks
                ];
            });

            return [
                'nama' => $first->nama_nakes,
                'kompetensi' => $first->kompetensi,
                'praktik' => $praktik->values()
            ];
        })->values();

        return $grouped;
        
    }

    public function nakescontext_new()
    {


        // Step 2: Build subquery (s0) from tbl_sip
        $s0 = DB::table('tbl_sip')
            ->select(
                'id as id_sip',
                'id_doc',
                'id_pengajuan',
                'id_nakes as id_user',
                'nama_nakes',
                'nama_faskes',
                'nama_lokasi',
                'valid_until',
                'kompetensi',
                'profesi',
                'salinan',
                'perubahan',
                'kec_lokasi'
            )
            ->where('status_sip', '1');

        // Step 2: Join with approved_jadwal (the actual schedule data)
        $query = DB::table('approved_jadwal')
            ->select(
                's0.id_sip',
                's0.id_doc',
                's0.id_pengajuan',
                's0.id_user',
                's0.nama_nakes',
                's0.nama_faskes',
                's0.nama_lokasi',
                's0.valid_until',
                's0.kompetensi',
                's0.salinan',
                's0.perubahan',
                's0.kec_lokasi',
                'approved_jadwal.detail_jadwal'
            )
            ->joinSub($s0, 's0', function ($join) {
                $join->on('approved_jadwal.id_pengajuan', 's0.id_pengajuan')
                    ->on('approved_jadwal.id_user', 's0.id_user')
                    ->on('approved_jadwal.id_doc', 's0.id_doc')
                    ->on('approved_jadwal.salinan', 's0.salinan')
                    ->on('approved_jadwal.perubahan', 's0.perubahan');
            })
            ->orderby('s0.id_sip');

        DB::table('tbl_nakes_context')->truncate();

        $query->chunk(500, function ($rows) {
            $insertBatch = [];

            foreach ($rows as $row) {
                $detail = json_decode($row->detail_jadwal, true);
                $jadwalText = '';

                if (is_array($detail)) {
                    $formatted = [];
                    foreach ($detail as $d) {
                        $hari = $d['hari'] ?? '';
                        $pukul = $d['pukul'] ?? '';

                        // Parse shift automatically
                        [$startTime, $endTime] = explode(' - ', $pukul . ' - ');
                        $shift = $this->getShiftName($startTime, $endTime);

                        $formatted[] = "hari {$hari} ({$shift}) ({$pukul})";
                    }
                    $jadwalText = implode(', ', $formatted);
                }

                $insertBatch[] = [
                    'id_sip' => $row->id_sip,
                    'nama_nakes' => $row->nama_nakes,
                    'kompetensi' => $row->kompetensi,
                    'faskes' => $row->nama_faskes,
                    'lokasi' => $row->nama_lokasi,
                    'kecamatan' => $row->kec_lokasi,
                    'jadwal_praktik' => $jadwalText,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            dd($insertBatch);

            DB::table('tbl_nakes_context')->insert($insertBatch);
        });

        return true;

    }

    public function nakescontext_old()
    {
        DB::table('tbl_nakes_context')->truncate();
        $batchSize = 500;
        $insertBatch = [];
        $totalInserted = 0;

        $query = DB::table('approved_jadwal')
            ->join('tbl_sip as s0', function ($join) {
                $join->on('approved_jadwal.id_pengajuan', 's0.id_pengajuan')
                    ->on('approved_jadwal.id_user', 's0.id_nakes')
                    ->on('approved_jadwal.id_doc', 's0.id_doc')
                    ->on('approved_jadwal.salinan', 's0.salinan')
                    ->on('approved_jadwal.perubahan', 's0.perubahan');
            })
            ->where('s0.status_sip', 1)
            ->select(
                's0.id_doc',
                's0.nama_nakes',
                's0.kompetensi',
                's0.nama_faskes',
                's0.nama_lokasi',
                's0.kec_lokasi',
                'approved_jadwal.detail_jadwal'
            )
            ->orderBy('s0.id_doc')
            ->limit(10);

        $query->chunk($batchSize, function ($rows) use (&$insertBatch, &$totalInserted) {
            foreach ($rows as $row) {
                $detail = json_decode($row->detail_jadwal ?? '[]', true);

                // ensure it's an array
                if (!is_array($detail)) {
                    $detail = [];
                }
                $hariList = [];
                $jamList = [];

                // collect days and time ranges
                foreach ($detail as $d) {
                    if (!empty($d['hari'])) $hariList[] = $d['hari'];
                    if (!empty($d['pukul'])) {
                        $jamList[] = $d['pukul'];
                    }
                }

                $hariText = $hariList ? implode(', ', array_unique($hariList)) : 'tidak disebutkan';
                $jamText = $jamList ? implode(', ', array_unique($jamList)) : 'tidak disebutkan';

                // Build natural-language context
                $context = "{$row->nama_nakes} adalah seorang {$row->kompetensi}. ";
                $context .= "Ia bekerja di {$row->nama_faskes}, berlokasi di {$row->nama_lokasi}, Kecamatan {$row->kec_lokasi}. ";
                $context .= "Jadwal praktiknya setiap hari {$hariText} pada pukul {$jamText}.";

                $insertBatch[] = [
                    'context' => $context,
                    'created_at' => now(),
                ];

                // bulk insert every ~500 rows
                if (count($insertBatch) >= 500) {
                    DB::table('tbl_nakes_context')->insert($insertBatch);
                    $totalInserted += count($insertBatch);
                    $insertBatch = [];
                }
            }

            if (!empty($insertBatch)) {
                DB::table('tbl_nakes_context')->insert($insertBatch);
                $totalInserted += count($insertBatch);
                $insertBatch = [];
            }
        });


        return $totalInserted;
    }

    public function nakescontext()
    {
        // Step 1: Build base subquery from tbl_sip
        $getfirst = DB::table('tbl_nakes_context')
            ->select(DB::raw('substr(created_at,1,10) as periode'))
            ->orderby('created_at', 'desc')
            ->first();

        if($getfirst)
        {
            $periode = $getfirst->periode;
            return DB::table('tbl_nakes_context')
                ->select('context')
                ->where(DB::raw('substr(created_at,1,10)'), $periode)
                ->get();

        } else {
            return false;
        }
    }

    private function getShiftName($start, $end)
    {
        // Convert to minutes safely
        $toMinutes = function ($time) {
            if (empty($time) || strpos($time, ':') === false) {
                // Default to 00:00 if invalid
                return 0;
            }

            $parts = explode(':', trim($time));
            $h = (int) ($parts[0] ?? 0);
            $m = (int) ($parts[1] ?? 0);

            return ($h * 60) + $m;
        };

        $startMin = $toMinutes($start);
        $endMin   = $toMinutes($end);

        // Determine start period
        if ($startMin < 720) {
            $startPeriod = 'pagi'; // before 12:00
        } elseif ($startMin < 900) {
            $startPeriod = 'siang'; // before 15:00
        } elseif ($startMin < 1080) {
            $startPeriod = 'sore'; // before 18:00
        } else {
            $startPeriod = 'malam';
        }

        // Determine end period
        if ($endMin <= 720) {
            $endPeriod = 'pagi';
        } elseif ($endMin <= 900) {
            $endPeriod = 'siang';
        } elseif ($endMin <= 1080) {
            $endPeriod = 'sore';
        } else {
            $endPeriod = 'malam';
        }

        return "{$startPeriod} - {$endPeriod}";
    }

    public function getallmaster($jenis)
    {
        if($jenis == 'profesi')
        {
            return DB::table('master_profesi')
                ->select('nama_profesi')
                ->orderby('nama_profesi')
                ->get();
        } else {

            return DB::table('master_faskes')
                ->select('nama_faskes')
                ->orderby('nama_faskes')
                ->get();

        }
    }

    public function getfakta($jenis)
    {
        if ($jenis == 'faskes')
        {

            return DB::table('tbl_sip')
            ->select(
                'nama_faskes',
                DB::raw("GROUP_CONCAT(CONCAT(jml, ' ', kompetensi) SEPARATOR ', ') AS kompetensi_summary")
            )
            ->fromSub(function ($query) {
                $query->select(
                        'nama_faskes',
                        'kompetensi',
                        DB::raw('COUNT(*) as jml')
                    )
                    ->from('tbl_sip')
                    ->where('status_sip', '1')
                    ->where('nama_faskes', '<>', '')
                    ->whereNotIn('kompetensi', ['1', '2', '20'])
                    ->groupBy('nama_faskes', 'kompetensi');
            }, 'x')
            ->groupBy('nama_faskes')
            ->orderBy('nama_faskes')
            ->get();

        } else {
            //
            return DB::table(DB::raw("
                (SELECT 
                    ab.kecamatan_faskes,
                    GROUP_CONCAT(CONCAT(ab.total, ' ', ab.kompetensi) SEPARATOR ', ') AS kompetensi_summary
                FROM (
                    SELECT 
                        c.kecamatan_faskes,
                        b.kompetensi,
                        COUNT(b.id) AS total
                    FROM tbl_pengajuan a
                    INNER JOIN tbl_sip b ON a.id = b.id_pengajuan
                    INNER JOIN master_faskes c ON a.id_faskes = c.id_faskes
                    WHERE b.status_sip = '1'
                    AND a.isFaskes = 1
                    GROUP BY c.kecamatan_faskes, b.kompetensi
                ) ab
                GROUP BY ab.kecamatan_faskes
                ) as x
            "))
            ->join(DB::raw("
                (SELECT 
                    ab.kec_lokasi,
                    GROUP_CONCAT(CONCAT(ab.total, ' ', ab.kompetensi) SEPARATOR ', ') AS kompetensi_summary
                FROM (
                    SELECT 
                        kec_lokasi,
                        kompetensi,
                        COUNT(id) AS total
                    FROM tbl_sip
                    WHERE status_sip = 1
                    AND nama_faskes = ''
                    GROUP BY kec_lokasi, kompetensi
                ) ab
                GROUP BY ab.kec_lokasi
                ) as y
            "), 'x.kecamatan_faskes', '=', 'y.kec_lokasi')
            ->join(DB::raw("
                (SELECT 
                    kecamatan_faskes,
                    COUNT(id_faskes) AS total
                FROM master_faskes
                WHERE status_faskes = 1
                GROUP BY kecamatan_faskes
                ) as z
            "), 'x.kecamatan_faskes', '=', 'z.kecamatan_faskes')
            ->select(
                'x.kecamatan_faskes',
                'x.kompetensi_summary as difaskes',
                'y.kompetensi_summary as mandiri',
                'z.total as total_faskes'
            )
            ->get();
        }
    }

    public function processmessage($request)
    {
        $pesan = $request->message;
        return DB::table('tbx_log')
            ->insert([
                'result' => $pesan,
                'update_date' => date('Y-m-d H:i:s')
            ]);
    }

    public function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; // Radius of the Earth in meters
    
        // Check if any of the latitude or longitude values are not well-formed numeric values
        if (!is_numeric($lat1) || !is_numeric($lon1) || !is_numeric($lat2) || !is_numeric($lon2)) {
            return 0;
        }
    
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $earthRadius * $c;
        
        return $distance;
    }

    public function getNearbyPoints($targetLat, $targetLon, $pointsArray, $maxDistance) {
        $nearbyPoints = [];
    
        foreach ($pointsArray as $point) {
            $lat = (float) $point->latitude; // Convert latitude to float
            $lon = (float) $point->longitude; 
            $distance = $this->haversineDistance($targetLat, $targetLon, $lat, $lon);

            if ($distance <= $maxDistance) {
                // Clone or extend point with distance
                $point->distance = $distance;
                $nearbyPoints[] = $point;
            }
        }
    
        return $nearbyPoints;
    }

    public function getnakessekitar($request) {

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $maximumDistance = 2000;
        $arrayid = [];

        if ($request->filled('distance')) {
            $maximumDistance = $request->input('distance');
        }
        if ($request->filled('isFaskes') && $request->filled('jenis_profesi')) {
            $jenis_profesi = $request->jenis_profesi;
            $s1 = DB::table('tbl_docs')
                ->select('id as id_doc', 'id_user', 'jenis_profesi')
                ->where('jenis_doc', 'like', 'STR%');

            $points = DB::table('tbl_pengajuan')
                ->select('id', 'longitude', 'latitude')
                ->joinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_user', 's1.id_user')->on('tbl_pengajuan.id_doc', 's1.id_doc');
                })
                ->where('isApproved', '4')
                ->whereNotIn('latitude', [$latitude, ''])
                ->whereNotIn('longitude', [$longitude, ''])
                ->where('s1.jenis_profesi', $jenis_profesi)
                ->where('isFaskes', 0)
                ->get()
                ->toArray();

            
        } else {

            $points = DB::table('tbl_pengajuan')
            ->select('id', 'longitude', 'latitude')
            ->where('isApproved', '4')
            ->whereNotIn('latitude', [$latitude, ''])
            ->whereNotIn('longitude', [$longitude, ''])
            ->get()
            ->toArray(); // Convert the collection to a plain array


        }
        

        
        $nearbyPoints = $this->getNearbyPoints($latitude, $longitude, $points, $maximumDistance);
        
        $distanceMap = [];
        foreach ($nearbyPoints as $point) {
            $distanceMap[$point->id] = round($point->distance, 1);
            $arrayid[] = $point->id; // Keep array of IDs for query
        }


        $s1 = DB::table('users')
            ->select('id', 'saved_photo', 'name')
            ->orderBy('last_login');

        $s2 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'profesi');

        $results = DB::table('tbl_pengajuan')
            ->select(
                'tbl_pengajuan.id',
                'alamat_pengajuan',
                's2.profesi',
                's1.saved_photo',
                's1.name',
                'nama_faskes',
                'latitude',
                'longitude'
            )
            ->leftJoinSub($s1, 's1', function ($join) {
                $join->on('tbl_pengajuan.id_user', 's1.id');
            })
            ->leftJoinSub($s2, 's2', function ($join) {
                $join->on('tbl_pengajuan.id_user', 's2.id_user');
            })
            ->where('isApproved', '4')
            ->whereIn('tbl_pengajuan.id', $arrayid)
            ->where('latitude', '<>', $latitude)
            ->where('longitude', '<>', $longitude)
            ->limit(20)
            ->get();

        // Attach distance from $distanceMap
        $results->transform(function ($row) use ($distanceMap) {
            $row->distance = $distanceMap[$row->id] ?? null;
            return $row;
        });

        return $results;
        
    }

    public function getfaskessekitar($request) {

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $maximumDistance = 2000;
        $arrayid = [];

        $pointsm = DB::table('tbl_pengajuan')
            ->select(DB::raw("CONCAT('M', id) as id"), 'longitude', 'latitude')
            ->where('isApproved', '4')
            ->where('isFaskes', '0')
            ->whereNotIn('latitude', [$latitude, ''])
            ->whereNotIn('longitude', [$longitude, '']);

        

        $pointss = DB::table('master_faskes')
            ->select('id_faskes as id', 'longitude', 'latitude')
            ->where('status_faskes', '1')
            ->whereNotIn('latitude', [$latitude, ''])
            ->whereNotIn('longitude', [$longitude, '']); // Convert the collection to a plain array

        $points = $pointss
            ->union($pointsm)
            ->get()
            ->toArray();

        $nearbyPoints = $this->getNearbyPoints($latitude, $longitude, $points, $maximumDistance);
        
        $distanceMap = [];
        foreach ($nearbyPoints as $point) {
            $distanceMap[$point->id] = round($point->distance, 1);
            $arrayid[] = $point->id; // Keep array of IDs for query
        }

        $s1 = DB::table('tbl_sip')
            ->select('id_pengajuan', 'nama_nakes')
            ->where('status_sip', '1');

        $resultm = DB::table('tbl_pengajuan')
            ->select(DB::raw("CONCAT('M', id) as id"), DB::raw("CONCAT('Praktik Mandiri ', s1.nama_nakes) as nama_faskes"), 'alamat_pengajuan as alamat_faskes', DB::raw("'' as jam_kerja") ,'latitude', 'longitude')
            ->joinsub($s1, 's1', function($join) {
                $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
            })
            ->where('isApproved', '4')
            ->where('isFaskes', '0')
            ->whereIn(DB::raw("CONCAT('M', id)"), $arrayid)
            ->whereNotIn('latitude', [$latitude, ''])
            ->whereNotIn('longitude', [$longitude, ''])
            ->limit(20)
            ->get();



        $results = DB::table('master_faskes')
            ->select(
                'master_faskes.id_faskes as id',
                'master_faskes.nama_faskes',
                'master_faskes.alamat_faskes',
                'master_faskes.jam_kerja',
                'latitude',
                'longitude'
            )
            ->where('status_faskes', '1')
            ->whereIn('master_faskes.id_faskes', $arrayid)
            ->where('latitude', '<>', $latitude)
            ->where('longitude', '<>', $longitude)
            ->limit(20)
            ->get();

        $results = $results->merge($resultm);


        // Attach distance from $distanceMap
        $results->transform(function ($row) use ($distanceMap) {
            $row->distance = $distanceMap[$row->id] ?? null;
            return $row;
        });

        return $results;
        
    }

    public function getfaskessekitarpage($request) {

        $whereRaw = "AND latitude LIKE '%%'";
        $whereRaw2 = "AND latitude LIKE '%%'";


        if ($keyword = trim($request->keyword ?? '')) {

            $whereRaw = ` AND s1.nama_nakes like '%`.$keyword.`%'`;
            $whereRaw2 = ` AND master_faskes.nama_faskes like '%`.$keyword.`%'`;

        }



        $s1 = DB::table('tbl_sip')
            ->select('id_pengajuan', 'nama_nakes')
            ->where('status_sip', '1');

        $resultm = DB::table('tbl_pengajuan')
            ->select(DB::raw("CONCAT('M', id) as id"), DB::raw("CONCAT('Praktik Mandiri ', s1.nama_nakes) as nama_faskes"), 'alamat_pengajuan as alamat_faskes', DB::raw("'' as jam_kerja") ,'latitude', 'longitude', DB::raw("'' as deskripsi"))
            ->joinsub($s1, 's1', function($join) {
                $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
            })
            ->where('isApproved', '4')
            ->where('isFaskes', '0')
            ->whereRaw($whereRaw);

        $results = DB::table('master_faskes')
            ->select(
                'master_faskes.id_faskes as id',
                'master_faskes.nama_faskes',
                'master_faskes.alamat_faskes',
                'master_faskes.jam_kerja',
                'latitude',
                'longitude',
                'deskripsi'
            )
            ->where('status_faskes', '1')
            ->whereRaw($whereRaw2);

        $combined = $results
            ->unionAll($resultm);
        
        $data = DB::query()
            ->fromSub($combined, 'faskes')
            ->paginate(10);


        return $data;
        
    }

    public function getdatasekitar($request)
    {

        if(isset($request->latitude) && isset($request->longitude))
        {
            $data['faskes'] = $this->getfaskessekitar($request);

        } else {

            $data['faskes'] = $this->getfaskessekitarpage($request);

        }
        //$data['nakes'] = $this->getnakessekitar($request);
        return $data;

    }

    public function detailfaskessekitar($request)
    {
        $id = $request->id;
        $urutan = date('N');
        
        if (substr($id, 0, 1) === 'M') {
            $id_pengajuan = substr($id, 1);
            $nama_nakes = '';
            $getnama = DB::table('tbl_sip')
                ->select('nama_nakes')
                ->where('id_pengajuan', $id_pengajuan)
                ->first();

            if($getnama)
            {
                $nama_nakes = $getnama->nama_nakes;
            }
            
            $hariini = $nama_nakes." Tidak Berpraktik Hari Ini";
            $ispraktik = DB::table('tbl_jadwalpraktik')
                ->select('mulai', 'selesai')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('urutan', $urutan)
                ->where('isSet', '1')
                ->first();
            if($ispraktik)
            {
                $hariini = $nama_nakes." Hari Ini Berpraktik Pukul: ".$ispraktik->mulai." Hingga: ".$ispraktik->selesai;

            }

            $data['hariini'] = $hariini;
            $data['jadwal'] = DB::table('tbl_jadwalpraktik')
                ->select(DB::raw("CONCAT('Jadwal Hari ', hari, ' Pada Pukul: ', mulai, ' Hingga: ',selesai)"))
                ->where('id_pengajuan', $id_pengajuan)
                ->where('isSet', '1')
                ->get();

            

        } else {

            $s1 = DB::table('tbl_jadwalpraktik')
                ->select('id_pengajuan', 'mulai', 'selesai')
                ->where('urutan', $urutan)
                ->where('isSet', '1');

            $s2 = DB::table('tbl_pengajuan')
                ->select('id')
                ->where('id_faskes', $id)
                ->where('isApproved', '4');

            $data['hariini'] = DB::table('tbl_sip')
                ->select(DB::raw("CONCAT(tbl_sip.kompetensi,' ',tbl_sip.nama_nakes', Berpraktik Pada Pukul: ', s1.mulai, ' Hingga: ',s1.selesai) as nakes"))
                ->joinsub($s1, 's1', function($join) {
                    $join->on('tbl_sip.id', 's1.id_pengajuan');
                })
                ->joinsub($s2, 's2', function($join) {
                    $join->on('tbl_sip.id_pengajuan', 's2.id');
                })
                ->where('tbl_sip.kompentesi', 'like', 'DOKTER%')
                ->where('tbl_sip.status_sip', '1')
                ->get();

        }
        return $data;


    }

    public function getpuskesmas($request)
    {
        return DB::table('master_faskes')
            ->select('id_faskes as id', 'nama_faskes', 'alamat_faskes', 'latitude', 'longitude')
            ->where('status_faskes', '1')
            ->where('nama_faskes', 'like', '%PUSKESMAS%')
            ->get();

    }

    public function updatepuskesmas($request)
    {
        $id_faskes = $request->id;
        $jenis = $request->jenis;
        $alamat_faskes = $request->alamat_puskesmas;
        $longitude = $request->longitude;
        $latitude = $request->latitiude;
        $berlaku_hingga = $request->berlaku_hingga;

        if($jenis == 1)
        {

            return DB::table('master_faskes')
                ->where('id', $id_faskes)
                ->update([
                    'alamat_faskes' => $alamat_faskes,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'berlaku_hingga' => $berlaku_hingga
                ]);

        } else {

            $nama_faskes = $request->nama_faskes;

            return DB::table('master_faskes')
                ->where('id', $id_faskes)
                ->insert([
                    'nama_faskes' => $nama_faskes,
                    'alamat_faskes' => $alamat_faskes,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'berlaku_hingga' => $berlaku_hingga
                ]);

        }

        
    }

}
