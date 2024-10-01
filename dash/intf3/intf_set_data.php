<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$inp = new stdClass();
$outp = new stdClass();
$inp = json_decode(file_get_contents('php://input'), false);

if(!isset($inp->token) || $inp->token != 'set_data')
    {
    $outp->err = 1;
    $outp->msg = "Parameter tidak lengkap !";
    echo json_encode($outp, JSON_NUMERIC_CHECK);
    return;
    }

$con = db_open();

// income parkir
if(isset($inp->parkir))
    {
    $p = $inp->parkir;
    for($i=0; $i<sizeof($p); $i++)
        sql_open($con, "delete from tt_sync_income_parkir where id_lokasi = ".$inp->id_lokasi." and tanggal = ".sql_string($p[$i]->tanggal));
            
    for($i=0; $i<sizeof($p); $i++)
        {
            sql_open($con, 
            "INSERT INTO tt_sync_income_parkir 
                (
                id_lokasi, 
                tanggal, 
                shift,
                kendaraan, 
                kategori, 
                tgl, 
                bln, 
                thn, 
                tarif, 
                cash, 
                prepaid, 
                casual, 
                pass ) 
                VALUES 
            (
                ".$inp->id_lokasi.", 
                ".sql_string($p[$i]->tanggal).", 
                ".sql_string($p[$i]->shift).", 
                ".sql_string($p[$i]->kendaraan).", 
                ".sql_string($p[$i]->kategori).", 
                ".$p[$i]->tgl.", 
                ".$p[$i]->bln.", 
                ".$p[$i]->thn.", 
                ".$p[$i]->tarif.", 
                ".$p[$i]->cash.", 
                ".$p[$i]->prepaid.", 
                ".$p[$i]->casual.", 
                ".$p[$i]->pass.");
                ");
        }
    }


// income member    
if(isset($inp->member))
    {
    $p = $inp->member;
    for($i=0; $i<sizeof($p); $i++)
        sql_open($con, "delete from tt_sync_income_member where id_lokasi = ".$inp->id_lokasi." and tanggal = ".sql_string($p[$i]->tanggal));

    for($i=0; $i<sizeof($p); $i++)
        {
            sql_open($con, 
            "INSERT INTO tt_sync_income_member
            (
                id_lokasi, 
                tanggal, 
                tgl, 
                bln, 
                thn, 
                member)
            VALUES 
            (
                ".$inp->id_lokasi.", 
                ".sql_string($p[$i]->tanggal).", 
                ".$p[$i]->tgl.", 
                ".$p[$i]->bln.", 
                ".$p[$i]->thn.", 
                ".$p[$i]->member.");
                ");
        }
    }


// income manual
if(isset($inp->manual))
    {
    $p = $inp->manual;
    for($i=0; $i<sizeof($p); $i++)
        sql_open($con, "delete from tt_sync_income_manual where id_lokasi = ".$inp->id_lokasi." and tanggal = ".sql_string($p[$i]->tanggal));

    for($i=0; $i<sizeof($p); $i++)
        {
            sql_open($con, 
            "INSERT INTO tt_sync_income_manual
            (
                id_lokasi, 
                tanggal, 
                shift, 
                tgl, 
                bln, 
                thn, 
                manual,
                masalah)
            VALUES 
            (
                ".$inp->id_lokasi.", 
                ".sql_string($p[$i]->tanggal).", 
                ".sql_string($p[$i]->shift).", 
                ".$p[$i]->tgl.", 
                ".$p[$i]->bln.", 
                ".$p[$i]->thn.", 
                ".$p[$i]->manual.", 
                ".$p[$i]->masalah.");
                ");
        }
    }


// income realtimr
if(isset($inp->realtime))
    {
    $p = $inp->realtime;
    for($i=0; $i<sizeof($p); $i++)
        sql_open($con, "delete from tt_sync_realtime where id_lokasi = ".$inp->id_lokasi);

    for($i=0; $i<sizeof($p); $i++)
        {
            sql_open($con, 
            "INSERT INTO tt_sync_realtime
            (
                id_lokasi, 
                tanggal, 
                shift,
                waktu, 
                kendaraan, 
                qty, 
                jumlah
            )
            VALUES 
            (
                ".$inp->id_lokasi.", 
                ".sql_string($p[$i]->tanggal).", 
                ".sql_string($p[$i]->shift).", 
                ".sql_string($p[$i]->waktu).", 
                ".sql_string($p[$i]->kendaraan).", 
                ".$p[$i]->qty.", 
                ".$p[$i]->jumlah.");
            ");
        }
    }


db_close($con);
$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>