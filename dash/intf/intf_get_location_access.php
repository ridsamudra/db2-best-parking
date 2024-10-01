<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'get_location_access')
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
$outp->lokasi = get_table_by_column($con, "SELECT l.id, l.site, CASE WHEN t.id_lokasi IS NOT NULL THEN 1 ELSE 0 END AS chk FROM tm_lokasi l LEFT JOIN (SELECT lu.id_lokasi FROM tm_lokasi_user lu INNER JOIN tm_user u ON lu.id_user = u.id WHERE u.id = ".$inp->id.")t ON l.id = t.id_lokasi");
db_close($con);

$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>