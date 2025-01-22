<?php
	include "config.php";
	$sql="DELETE FROM category where CategoryID='$_GET[id]'";
	if ($conn->query($sql))
	header("location:category-view.php");
	else
	echo "error";
?>