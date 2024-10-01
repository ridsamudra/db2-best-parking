<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'get_user_location')
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
if($_SESSION['admin'.constant('app_name')] == 1)
    $resp = get_table_by_column($con, "SELECT l.id, l.site FROM tm_lokasi l");
else
    $resp = get_table_by_column($con, "SELECT l.id, l.site FROM tm_user u INNER JOIN tm_lokasi_user lu ON u.id = lu.id_user INNER JOIN tm_lokasi l ON lu.id_lokasi = l.id where u.id_user =".sql_string($_SESSION['id_user'.constant('app_name')]) );

db_close($con);
$outp->err = 0;
$outp->msg = "Sukses !";
$outp->lokasi_user = $resp;
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>