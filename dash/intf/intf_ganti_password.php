<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!is_logged())
    {
    $outp->err = 1;
    $outp->msg = "User belum login !";
    echo json_encode($outp, JSON_NUMERIC_CHECK);
    return;
    }

 if($_SESSION['password'.constant('app_name')] != $inp->pass_lama)
    {
    $outp->err = 1;
    $outp->msg = "Password salah !";
    echo json_encode($outp, JSON_NUMERIC_CHECK);
    return;
    }

$con = db_open();
sql_open($con, "update tm_user set password = '".$inp->pass_baru."' where id = ".$_SESSION['id'.constant('app_name')]);
db_close($con);

$_SESSION['password'.constant('app_name')] = $inp->pass_baru;

$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>