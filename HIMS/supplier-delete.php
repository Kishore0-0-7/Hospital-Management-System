<?php
	include "config.php";
	$sql="DELETE FROM supplier where SupplierID='$_GET[id]'";
	if ($conn->query($sql)){
	header("location:supplier-view.php");}
	else
	echo "error";
?>