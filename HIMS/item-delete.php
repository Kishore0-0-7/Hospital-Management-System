<?php
	include "config.php";
	$sql="DELETE FROM item where ItemID='$_GET[id]'";
	if ($conn->query($sql))
	header("location:item-view.php");
	else
	echo "error";
?> 