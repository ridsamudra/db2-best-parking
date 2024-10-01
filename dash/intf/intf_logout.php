<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$outp = new stdClass();
$inp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(is_logged())
    {
        $con = db_open();
        add_log($con, "Logout");
        db_close($con);
    }

if(session_name() == constant('app_name'))
    session_destroy();
$outp->err = 0;
$outp->msg = "You are not logged !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>