<?php
if (isset($_GET['file']) && isset($_GET['map'])) {
	$file = $_GET['file'];
	$map = $_GET['map'];
	$file = "uploads/" . $map . "/" . $file;
	unlink($file);
	echo "<meta http-equiv='refresh' content='0;URL=uploads.php?map=" . $map . "'>";
} else {
	echo "No file selected!";
}
?>