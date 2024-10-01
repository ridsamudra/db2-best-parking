<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

$con = db_open();
$rs = sql_open($con, "select * from tm_user where id_user = '".$inp->id_user."'");
if(record_count($rs) == 0)
	{
	$outp->err = 1;
	$outp->msg = "User tidak ditemukan !";
	echo json_encode($outp, JSON_NUMERIC_CHECK);
	db_close($con);
	return;
	}

$row = fetch_row($rs);
if($row['password'] != $inp->password)
	{
	$outp->err = 1;
	$outp->msg = "Password salah !";
	echo json_encode($outp, JSON_NUMERIC_CHECK);
	db_close($con);
	return;
	}

$outp->err = 0;
$outp->msg = "Sukses !";
$outp->id = $row['id'];
$outp->id_user = $row['id_user'];
$outp->nama_user = $row['nama_user'];
$outp->admin = $row['admin'];

$_SESSION['id'.constant('app_name')] = $row['id'];
$_SESSION['id_user'.constant('app_name')] = $row['id_user'];
$_SESSION['nama_user'.constant('app_name')] = $row['nama_user'];
$_SESSION['admin'.constant('app_name')] = $row['admin'];
$_SESSION['password'.constant('app_name')] = $row['password'];
$_SESSION['logged'.constant('app_name')] = true;

add_log($con, "Login");
db_close($con);
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>