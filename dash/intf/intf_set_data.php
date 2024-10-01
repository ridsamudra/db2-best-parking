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

// pos aktif & trafic
if(isset($inp->pos))
    {
    $p = $inp->pos;
    sql_open($con, "delete from tt_pos_aktif where id_lokasi = ".$inp->id_lokasi);

    for($i=0; $i<sizeof($p); $i++)
        {
            sql_open($con, 
            "INSERT INTO tt_pos_aktif
            (
                id_lokasi, 
                pos, 
                aktif,
                trafic
            )
            VALUES 
            (
                ".$inp->id_lokasi.", 
                ".sql_string($p[$i]->pos).", 
                ".$p[$i]->aktif.", 
                ".$p[$i]->trafic.");
            ");
        }

        $outp->pos = $p;
    
    }


// transaksi per jam
if(isset($inp->trx_per_our))
    {
    $p = $inp->trx_per_our;
    sql_open($con, "delete from tt_data_hour where id_lokasi = ".$inp->id_lokasi);
    $str = "INSERT INTO tt_data_hour
    (id_lokasi, jam_0, jam_1, jam_2, jam_3, jam_4, jam_5, jam_6, jam_7, jam_8, jam_9, jam_10, jam_11, jam_12, jam_13, jam_14, jam_15, jam_16, jam_17, jam_18, jam_19, jam_20, jam_21, jam_22, jam_23, tarif_0, tarif_1, tarif_2, tarif_3, tarif_4,
    tarif_5, tarif_6, tarif_7, tarif_8, tarif_9, tarif_10, tarif_11, tarif_12, tarif_13, tarif_14, tarif_15, tarif_16, tarif_17, tarif_18, tarif_19, tarif_20, tarif_21, tarif_22, tarif_23)
    VALUES (
    ".$inp->id_lokasi.", 
    ".$p[0].", ".$p[1].", ".$p[2].", ".$p[3].", ".$p[4].", ".$p[5].", ".$p[6].", ".$p[7].", ".$p[8].", ".$p[9].", ".$p[10].", ".$p[11].", 
    ".$p[12].", ".$p[13].", ".$p[14].", ".$p[15].", ".$p[16].", ".$p[17].", ".$p[18].", ".$p[19].", ".$p[20].", ".$p[21].", ".$p[22].", 
    ".$p[23].", ".$p[24].", ".$p[25].", ".$p[26].", ".$p[27].", ".$p[28].", ".$p[29].", ".$p[30].", ".$p[31].", ".$p[32].", ".$p[33].", 
    ".$p[34].", ".$p[35].", ".$p[36].", ".$p[37].", ".$p[38].", ".$p[39].", ".$p[40].", ".$p[41].", ".$p[42].", ".$p[43].", ".$p[44].",
    ".$p[45].",".$p[46].",".$p[47].")";

      sql_open($con, $str);
//    $outp->data = $str;

    }


db_close($con);
$outp->err = 0;
$outp->msg = "Sukses !";
echo json_encode($outp, JSON_NUMERIC_CHECK);
?>