<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'get_user')
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
$outp->user = get_table($con, "select id as 'ID', id_user as 'ID User', nama_user as 'Nama User' from tm_user where admin = 0");
db_close($con);

$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>