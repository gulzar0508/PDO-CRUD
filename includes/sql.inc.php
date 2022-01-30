<?php
// sql functions
function sql_query($q)
{
	global $CON;

	$res = $CON->query($q);

	return $res;
}

function sql_num_rows($r)
{
	$res =  $r->fetchColumn();
	return $res;
}

function sql_fetch_row($r)
{
	$res = $r->fetch(PDO::FETCH_NUM);
	return $res;
}
?>