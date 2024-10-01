<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'delete_user')
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

$rs = sql_open($con, "select * from tm_user where id = ".$inp->id);
if(record_count($rs))
    {
        $row = fetch_row($rs);
        add_log($con, "Hapus user ".$row['id_user']);
    }

$rs = sql_open($con, "delete from tm_user where id = ".$inp->id);
db_close($con);   

$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>