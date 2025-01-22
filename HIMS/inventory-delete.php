<?php
	include "config.php";
	$sql="DELETE FROM inventory where InventoryID='$_GET[id]'";
	if ($conn->query($sql))
	header("location:inventory-view.php");
	else
	echo "error";
?>