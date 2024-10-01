<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'set_location_access')
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
sql_open($con, "delete from tm_lokasi_user where id_user = ".$inp->id);
for($i=0; $i<count($inp->lokasi); $i++)
    {
    sql_open($con, "insert into tm_lokasi_user (id_lokasi, id_user) values (".$inp->lokasi[$i].", ".$inp->id.")");
    }
db_close($con);

$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>