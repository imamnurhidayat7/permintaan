<?php

function convert_date($tanggal){
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

function amankan($x) {
    $search  = array('SELECT', ' UNION ', ' AND ', ' OR ');
    $replace = array('', '', '', '', '');
    
    $kataAman = strip_tags($x);
    $kataAman = str_replace("'","",$kataAman);
    $kataAman = str_replace("--","",$kataAman);
    $kataAman = str_replace(";","",$kataAman);
    $kataAman = str_ireplace($search,$replace,$kataAman); 
     
    return $kataAman;
}