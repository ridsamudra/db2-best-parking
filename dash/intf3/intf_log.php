<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
$con = db_open();

$rs = sql_open($con, "select * from tt_log order by id desc limit 100");
$data = '';
for($i=0; $i<record_count($rs); $i++)
    {
    $row = fetch_row($rs);
    $tgl = $row['waktu'];
    $user = $row['id_user'];
    $ket = $row['ket'];
    $r = '<tr><td>'.$tgl.'</td><td>'.$user.'</td><td>'.$ket.'</td></tr>';
    $data = $data.$r;
    }


echo '
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body 
            {
            font-family:"Calibri";
            font-size:"10px";
            margin:0px;
            }
        table, td, th 
            {
            white-space: nowrap;
            border-collapse	: collapse;
            border:1px solid gray;
            margin:0px;
            padding : 5px;
            color : gray;
            font-size:90%;
            }
        div {
            border: 0px solid gray;
            box-sizing: border-box;
            }
    
    </style>
</head>
<body>

    <div style = "height:100vh; overflow:auto;padding:10px;">
        <table>
        <tr>
        <th>Waktu</th>
        <th>User</th>
        <th>Keterangan</th>
        </tr>'.$data.'</table>
    </div>

</body>
</html>
';


db_close($con);
?>