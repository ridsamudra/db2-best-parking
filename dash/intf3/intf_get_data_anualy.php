<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'get_data_anualy')
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
        array_push($outp->lokasi, $lok);
        // data 6 tahun terakhir
        $lok->income = get_table($con, 
        "
        SELECT 
        t4.thn AS Tahun,
        t4.cash AS 'Tarif Tunai',
        t4.prepaid AS 'Tarif Prepaid',
        t4.member AS Member,
        t4.manual AS Manual,
        (t4.masalah) AS 'Tiket Masalah',
        (t4.tarif + t4.manual + t4.member - t4.masalah) AS 'Total Pendapatan',
        t4.casual AS 'Qty. Casual',
        t4.pass AS 'Qty. Pass',
        (t4.casual + t4.pass) AS 'Total Qty'
        FROM
        (SELECT
        t1.thn,
        t1.tarif,
        t1.prepaid,
        t1.cash,
        t1.casual,
        t1.pass,
        CASE WHEN t2.member IS NOT NULL THEN t2.member ELSE 0 END AS member,
        CASE WHEN t3.manual IS NOT NULL THEN t3.manual ELSE 0 END AS manual,
        CASE WHEN t3.masalah IS NOT NULL THEN t3.masalah ELSE 0 END AS masalah
        FROM
        (SELECT thn, SUM(tarif) AS tarif, SUM(prepaid) AS prepaid, SUM(cash) AS cash, SUM(casual) AS casual, SUM(pass) AS pass FROM tt_sync_income_parkir WHERE id_lokasi = ".$inp->lokasi[$i]." GROUP BY thn)t1
        LEFT JOIN
        (SELECT thn, SUM(member) AS member FROM tt_sync_income_member WHERE id_lokasi = ".$inp->lokasi[$i]." GROUP BY thn)t2 ON (t1.thn = t2.thn)
        LEFT JOIN
        (SELECT thn, SUM(manual) AS manual, SUM(masalah) AS masalah FROM tt_sync_income_manual WHERE id_lokasi = ".$inp->lokasi[$i]." GROUP BY thn)t3 ON (t1.thn = t3.thn))t4
        ORDER BY t4.thn
        ");
    }

add_log($con, "Lihat pendapatan tahunan");
db_close($con);


$outp->err = 0;
$outp->msg = "Sukses !";
$outp->a = $inp->lokasi;

echo json_encode($outp, JSON_NUMERIC_CHECK);
?>