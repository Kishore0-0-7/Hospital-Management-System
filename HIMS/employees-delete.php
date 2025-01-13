<?php
	include "config.php";
	$sql="DELETE FROM employees where EMP_ID='$_GET[id]'";
	if ($conn->query($sql))
	header("location:employees-view.php");
	else
	echo "error";
?> 