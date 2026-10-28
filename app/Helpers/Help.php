<?php
namespace App\Helpers;

class Help{
	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}


	function tgl_indo_sip($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return (int)$pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}


	function tgl_indo_apoteker($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return $pecahkan[0] . '' .$pecahkan[1]. '' . $pecahkan[2];
	}

	function standardiff($tanggal) {
		$now = date('Y-m-d H:i:s');
		$tglnow = strtotime($now);
		$tglbefore = strtotime($tanggal);
		$difference = round(abs($tglnow - $tglbefore) / 60);
		$differenceh = round(abs($tglnow - $tglbefore) / 3600);
		$differenced = round(abs($tglnow - $tglbefore) / 86400);
		$differencew = round(abs($tglnow - $tglbefore) / 604800);
		$differencem = round(abs($tglnow - $tglbefore) / 2592000);
		if ($difference < 60) {
			$perbedaan = $difference." menit yang lalu";
		} else if ($difference < 1440 && $difference >= 60) {
			$perbedaan = $differenceh." jam lalu";
		} else if ($difference < 10080 && $difference >= 1440 ) {
			$perbedaan = $differenced." hari lalu";
			
		} else if ($difference < 40320 && $difference >= 10080) {
			$perbedaan = $differencew." minggu lalu";
		} else if ($difference < 525600 && $difference >= 40320) {
			$perbedaan = $differencem." bulan lalu";
		} else {
			$perbedaan = substr($tanggal,0,10);
		}

		return $perbedaan;

	}

	function hariIndo($date)
    {
        // Convert string to Carbon instance
        $carbon = \Carbon\Carbon::parse($date);

        // Map days to Indonesian
        $days = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => "Jum'at",
            'Saturday'  => 'Sabtu',
        ];

        $englishDay = $carbon->format('l'); // returns English day name
        return $days[$englishDay];
    }
}
