<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'save_user')
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
if($inp->id == -1)
    {
        $rs = sql_open($con, "select * from tm_user where id_user = ".sql_string($inp->id_user));
        if(record_count($rs))
            {
                db_close($con);
                $outp->err = 1;
                $outp->msg = "ID User sudah ada !";
                echo json_encode($outp, JSON_NUMERIC_CHECK);
                return;
            }
        sql_open($con, "insert into tm_user(id_user, nama_user, password, admin) values(".sql_string($inp->id_user).",".sql_string($inp->nama_user).", '1234', 0)");
        $outp->msg = "User berhasil ditambahkan. Password default '1234' !";
        add_log($con, "Tambah user ".$inp->id_user);
    }
else
    {
        $rs = sql_open($con, "select * from tm_user where id <> ".$inp->id." and id_user = ".sql_string($inp->id_user));
        if(record_count($rs))
            {
                db_close($con);
                $outp->err = 1;
                $outp->msg = "ID User sudah ada !";
                echo json_encode($outp, JSON_NUMERIC_CHECK);
                return;
            }
        
        $rs = sql_open($con, "select * from tm_user where id = ".$inp->id);
        if(record_count($rs))
            {
                $row = fetch_row($rs);
                add_log($con, "Edit user ".$row['id_user']);
            }
    
        sql_open($con, "update tm_user set id_user = ".sql_string($inp->id_user).", nama_user = ".sql_string($inp->nama_user)." where id = ".$inp->id);
        $outp->msg = "Data user berhasil diubah !";
    }


db_close($con);    
$outp->err = 0;
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>