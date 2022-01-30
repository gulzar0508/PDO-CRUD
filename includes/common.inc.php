<?php
function GetConnected()
{
	$CON = false;
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

	try {
		$CON = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

		if ($CON) {
			// echo "Connected to the ".DB_NAME." database successfully!";
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	return $CON;
}

function DFA($arr="")
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function IsUniqueEntry($id_fld, $id_val, $txt_fld, $txt_val, $tbl)
{
	$ret_val = '2';
	$curr_txt = (isset($id_val))? GetXFromYID("select $txt_fld from $tbl where $id_fld=$id_val"): "";
	
	if($txt_val!='' && $txt_val != $curr_txt) // no change in value, ignore
	{
		$q_str = (isset($id_val))? " and $id_fld!=$id_val": "";
		$chk = GetXFromYID("select count(*) from $tbl where $txt_fld='$txt_val' " . $q_str);

		$ret_val = ($chk)? '0': '1';
	}
	
	return $ret_val;
}

function GetXFromYID($q)
{
	$str = false;
	$result = sql_query($q); 
	
	$data = $result->fetch(PDO::FETCH_NUM);
	if(isset($data) && count($data))
	{
		list($str) =$data;
	}
	return $str;
}

function NextID($f,$tbl, $base_num='0', $cond='')
{
	$cond_str = (trim($cond)!='')? ' where '.$cond: '';

	$query = "select max($f) from $tbl $cond_str";
	$result = sql_query($query); 
	list($rid)=sql_fetch_row($result);

	if(!is_numeric ( $rid))
		$rid=0;

	$rid++;

	if(!empty($base_num))
	{
		$_id = GetXFromYID("select $base_num from sys_config");
		if($rid < $_id)
			$rid = $_id;
	}

	return $rid;			
}

function ForceOut($err=false)
{
	$str = ($err===false)? '': '?err='.$err;
	session_destroy(); // destroy all data in session
	header("location:index.php".$str);
	exit;
}


function FormatDate($date_str="", $format="d M Y")
{
	$ret_str = "";
	if(!empty($date_str))
	{
		$ret_str = date($format, strtotime($date_str));
	}

	return $ret_str;
}

function CheckForXSS($string)
{
	$str = '';
	$x = array('onblur','onchange','onclick','ondblclick','onfocus','onkeydown','onkeypress','onkeyup','onmousedown','onmousemove','onmouseout','onmouseover','onmouseup','onreset','onselect','onsubmit');
	$str = str_replace($x,"",$string);

	return $str;
}

function db_input($string)
{
	$string = CheckForXSS($string);
	return htmlspecialchars(addslashes($string));
}

function IsExistFile($file, $path)
{
	$file = trim($file);
	$path = trim($path);
	
	if( ($file != "") && (strtoupper($file) != "NA") )
	{
		$f = $path . $file;
		//echo($f);
		//exit;
		if(file_exists($f))
			return 1;
	}

	return 0;
}

function DeleteFile($file, $path)
{
	$file = trim($file);
	$path = trim($path);
	
	if( ($file != "") && (strtoupper($file) != "NA") )
	{
		$f = $path . $file;
		if(file_exists($f))
			unlink ($f);
	}
}

function IsValidFile($file_type, $extension, $type, $size=false, $max_file_size=false)
{
	global $IMG_TYPE, $DOC_TYPE, $IMG_FILE_TYPE, $DOC_FILE_TYPE;

	$str = false;

	if($type=='P')
	{
		if(in_array($extension,$IMG_TYPE))
			$str = true;
	}
	elseif($type=='D')
	{
		if(in_array($extension,$DOC_TYPE))
			$str = true;
	}

	return $str;
}
?>