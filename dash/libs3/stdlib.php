<?php
function is_logged()
	{
	if(isset($_SESSION['id_user'.constant('app_name')]))
		return true;
	return false;
	}

// output : connection
function db_open()
	{
	$db_server = constant('db_svr');
	$db_user = constant('db_usr');
	$db_pass = constant('db_pwd');
	$db_name = constant('db_name');
	try
		{
		$con = mysqli_connect($db_server, $db_user, $db_pass);
		if($con)
			{
			mysqli_query($con, 'use '.$db_name);
			mysqli_query($con, "SET time_zone = '+07:00';");
			}
		}
	catch (Exception $e)
		{
		$con = false;
		}
	return $con;
	}

// input : connection	
function db_close($con)	
	{
	mysqli_close($con);
	}

// input : connection
function db_finish_sp($con)
	{
	mysqli_next_result($con);
	}


// input : str
// output : str with quote
function sql_string($str1)
	{
	$str2 = "";
	$len = strlen($str1);
	for($i=0; $i<$len; $i++)
		{
		if($str1[$i] == "'")
			$str2 = $str2.'\\';
		$str2 = $str2.$str1[$i];
		}
	return "'".$str2."'";
	}

// input : str
// output : str without quote
function sql_string_2($str1)
	{
	$str2 = "";
	$len = strlen($str1);
	for($i=0; $i<$len; $i++)
		{
		if($str1[$i] == "'")
			$str2 = $str2.'\\';
		$str2 = $str2.$str1[$i];
		}
	return $str2;
	}

// input : str
// output : str
function trim_nopol($str1)
	{
	$str2 = "";
	$len = strlen($str1);
	for($i=0; $i<$len; $i++)
		{
		if(('A' <= $str1[$i] && $str1[$i] <= 'Z') || ('0' <= $str1[$i] && $str1[$i] <= '9'))
			$str2 = $str2.$str1[$i];
		}
	return $str2;
	}

// input : connection, sql_string
// output : table object
function get_table($con, $str)
	{
	$tab_obj = new stdClass();
	$tab_obj->col_count = 0;
	$tab_obj->col_name = array();
	$tab_obj->row_count = 0;
	$tab_obj->rows = array();
	// additional info
	$tab_obj->min = array();
	$tab_obj->max = array();
	$tab_obj->avg = array();
	$tab_obj->total = array();
	$tab_obj->visible = array();
	$tab_obj->numeric = array();

	$rs = sql_open($con, $str);
	$tab_obj->col_count = mysqli_num_fields($rs);
	$field_name = $rs->fetch_fields();
	for($i=0; $i < $tab_obj->col_count; $i++)
		{
			array_push($tab_obj->col_name, $field_name[$i]->name);
			// additional min, max, avg, visible
			array_push($tab_obj->visible, 1);
			array_push($tab_obj->numeric, is_numeric_field($field_name[$i]->type));
			array_push($tab_obj->min, 9999999999.9);
			array_push($tab_obj->max, -9999999999.9);
			array_push($tab_obj->avg, 0.0);
			array_push($tab_obj->total, 0.0);
		}

	while($row = fetch_row($rs))
		{
		$r = array();
		for($i = 0; $i < $tab_obj->col_count; $i++)
			{
			$val = $row[$field_name[$i]->name];
			array_push($r, $val);
			// additional min, max, avg
			if($tab_obj->numeric[$i])
				{
				if($tab_obj->max[$i] < $val)
					$tab_obj->max[$i] = $val;
				if($tab_obj->min[$i] > $val)
					$tab_obj->min[$i] = $val;
				$tab_obj->avg[$i] += $val;
				$tab_obj->total[$i] += $val;
				}
			else	
				{
				$tab_obj->min[$i] = 0;
				$tab_obj->max[$i] = 0;
				$tab_obj->avg[$i] = 0;
				}
			}
		array_push($tab_obj->rows, $r);
		$tab_obj->row_count++;
		}

	// create average
	if($tab_obj->row_count > 0)
		{
		for($i = 0; $i < $tab_obj->col_count; $i++)
			{
			if($tab_obj->numeric[$i])
				$tab_obj->avg[$i] /= $tab_obj->row_count;
			}
		}

	return $tab_obj;
	}


// input : connection, sql_string
// output : array of column data
function get_table_by_column($con, $str)
	{
	$rs = sql_open($con, $str);
	$col_count = mysqli_num_fields($rs);
	$col_name = $rs->fetch_fields();
	$columns = array();
	for($i = 0; $i < $col_count; $i++)
		array_push($columns, array());

	while($row = fetch_row($rs))
		{
		for($i = 0; $i < $col_count; $i++)
			array_push($columns[$i], $row[$col_name[$i]->name]);
		}
	return $columns;
	}


// input : connection, sql_string
// output : array of row data
function get_table_by_row($con, $str)
	{
	$rs = sql_open($con, $str);
	$col_count = mysqli_num_fields($rs);
	$col_name = $rs->fetch_fields();
	$rows = array();

	while($row = fetch_row($rs))
		{
		$r = array();
		for($i = 0; $i < $col_count; $i++)
			array_push($r, $row[$col_name[$i]->name]);
		array_push($rows, $r);
		}
	return $rows;
	}


function is_numeric_field($code)
	{
	if(	$code == 16
		|| $code == 1
		|| $code == 2
		|| $code == 9
		|| $code == 3
		|| $code == 8
		|| $code == 4
		|| $code == 5
		|| $code == 246
		)
		return 1;
	return 0;
	}

	function read_db_setting($con, $id_lokasi, $nama)
	{
	$nilai = "";
	$rs = sql_open($con, "select * from tm_setting where nama = '".$nama."' and id_lokasi = ".$id_lokasi);
	if(record_count($rs) == 0)
		return $nilai;
	$row = fetch_row($rs);
	$nilai = $row['nilai'];
	return $nilai;
	}
	
// input : connection, sql string
// output : record set
function sql_open($con, $str)
	{
	return mysqli_query($con, $str);
	}
	
// input : record set
// output : count
function record_count($rec)	
	{
	return mysqli_num_rows($rec);
	}
	
// input : recorde set
// output : row	
function fetch_row($rec)
	{
	return mysqli_fetch_assoc($rec);
	}
	
function add_log($con, $ket)
	{
	sql_open($con, "insert into tt_log(waktu, id_user, ket) values (now(), ".sql_string($_SESSION['id_user'.constant('app_name')]).", ".sql_string($ket).")");
	}
	

?>