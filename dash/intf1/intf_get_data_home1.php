<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'get_data_home')
    {
    $outp->err = 1;
    $outp->msg = "Parameter tidak lengkap !";
    echo json_encode($outp, JSON_NUMERIC_CHECK);
    return;
    }

if(!is_logged())
    {
    $outp->err = 1;
    $outp->msg = "User belum login !";
    echo json_encode($outp, JSON_NUMERIC_CHECK);
    return;
    }

$con = db_open();
$outp->lokasi = array();
for($i=0; $i<sizeof($inp->lokasi); $i++)
    {
        // info
        $lok = new stdClass();
        $lok->info = get_table_by_row($con, "select pengelola, site, alamat from tm_lokasi where id = ".$inp->lokasi[$i]);
        // income realtime
        array_push($outp->lokasi, $lok);
        $lok->realtime = get_table_by_row($con, "select kendaraan, sum(qty) as qty, sum(jumlah) as jumlah, tanggal, waktu from tt_sync_realtime where id_lokasi = ".$inp->lokasi[$i]." group by tanggal, waktu, kendaraan ");
        // data 7 hari terakhir
        $lok->income7 = get_table_by_row($con, 
        "
        SELECT t1.tanggal, t1.tarif + (CASE WHEN t2.tanggal IS NOT NULL THEN t2.member ELSE 0 END) + (CASE WHEN t3.tanggal IS NOT NULL THEN t3.manual ELSE 0 END) - (CASE WHEN t3.tanggal IS NOT NULL THEN t3.masalah ELSE 0 END) AS total
        FROM (SELECT tanggal, SUM(tarif) AS tarif FROM tt_sync_income_parkir WHERE id_lokasi = ".$inp->lokasi[$i]." AND tanggal >= DATE_ADD(CONVERT(NOW(), DATE), INTERVAL -6 DAY) AND tanggal <= CONVERT(NOW(), DATE) GROUP BY tanggal)t1 
        LEFT JOIN (SELECT tanggal, member FROM tt_sync_income_member WHERE id_lokasi = ".$inp->lokasi[$i]." AND tanggal >= DATE_ADD(CONVERT(NOW(), DATE), INTERVAL -6 DAY) AND tanggal <= CONVERT(NOW(), DATE))t2 ON t1.tanggal = t2.tanggal
        LEFT JOIN (SELECT tanggal, SUM(manual) AS manual, SUM(masalah) AS masalah FROM tt_sync_income_manual WHERE id_lokasi = ".$inp->lokasi[$i]." AND tanggal >= DATE_ADD(CONVERT(NOW(), DATE), INTERVAL -6 DAY) AND tanggal <= CONVERT(NOW(), DATE) GROUP BY tanggal)t3  ON t1.tanggal = t3.tanggal order by tanggal
        ");

        // data 6 bulan terakhir
        $lok->income6 = get_table_by_row($con,
        "
        SELECT 
        t1.tanggal, 
        t1.tarif + (CASE WHEN t2.tanggal IS NOT NULL THEN t2.member ELSE 0 END) + (CASE WHEN t3.tanggal IS NOT NULL THEN t3.manual ELSE 0 END) - (CASE WHEN t3.tanggal IS NOT NULL THEN t3.masalah ELSE 0 END) AS total
        FROM 
            (SELECT (bln + thn * 100) AS tanggal, SUM(tarif) AS tarif FROM tt_sync_income_parkir WHERE id_lokasi = ".$inp->lokasi[$i]." AND ((MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) + YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) * 100) <= (bln + thn * 100) AND (bln + thn * 100) <= (MONTH(now()) + YEAR(now()) * 100)) GROUP BY thn, bln)t1 
        LEFT JOIN 
            (SELECT (bln + thn * 100) AS tanggal, SUM(member) AS member FROM tt_sync_income_member WHERE id_lokasi = ".$inp->lokasi[$i]." AND ((MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) + YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) * 100) <= (bln + thn * 100) AND (bln + thn * 100) <= (MONTH(now()) + YEAR(now()) * 100)) GROUP BY thn, bln)t2 ON t1.tanggal = t2.tanggal
        LEFT JOIN 	
            (SELECT (bln + thn * 100) AS tanggal, SUM(manual) AS manual, SUM(masalah) AS masalah FROM tt_sync_income_manual WHERE id_lokasi = ".$inp->lokasi[$i]." AND ((MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) + YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) * 100) <= (bln + thn * 100) AND (bln + thn * 100) <= (MONTH(now()) + YEAR(now()) * 100)) GROUP BY thn, bln)t3  ON t1.tanggal = t3.tanggal
        ");

        // data 6 tahun terakhir
        $lok->income62 = get_table_by_row($con, 
        "
        SELECT 
        t1.tanggal, 
        t1.tarif + (CASE WHEN t2.tanggal IS NOT NULL THEN t2.member ELSE 0 END) + (CASE WHEN t3.tanggal IS NOT NULL THEN t3.manual ELSE 0 END) - (CASE WHEN t3.tanggal IS NOT NULL THEN t3.masalah ELSE 0 END) AS total
        FROM 
            (SELECT thn AS tanggal, SUM(tarif) AS tarif FROM tt_sync_income_parkir WHERE id_lokasi = ".$inp->lokasi[$i]." AND YEAR(DATE_ADD(now(), INTERVAL -5 YEAR)) <= thn AND thn <= YEAR(now()) GROUP BY thn)t1 
        LEFT JOIN 
            (SELECT thn AS tanggal, SUM(member) AS member FROM tt_sync_income_member WHERE id_lokasi = ".$inp->lokasi[$i]." AND YEAR(DATE_ADD(now(), INTERVAL -5 YEAR)) <= thn AND thn <= YEAR(now()) GROUP BY thn)t2 ON t1.tanggal = t2.tanggal
        LEFT JOIN 	
            (SELECT thn AS tanggal, SUM(manual) AS manual, SUM(masalah) AS masalah FROM tt_sync_income_manual WHERE id_lokasi = ".$inp->lokasi[$i]." AND YEAR(DATE_ADD(now(), INTERVAL -5 YEAR)) <= thn AND thn <= YEAR(now()) GROUP BY thn)t3  ON t1.tanggal = t3.tanggal
        ");

    }

db_close($con);


$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>