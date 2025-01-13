<?php
	include "config.php";
	$sql="DELETE FROM transaction where Transaction_id='$_GET[id]'";
	if ($conn->query($sql))
	header("location:transaction-view.php");
	else
	echo "error";
?>