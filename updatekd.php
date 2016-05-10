<?php
if(isset($_GET['username'])) {
	$username = $_GET['username'];
	include 'db/connect.php';
	$getstats = mysqli_query($db, "SELECT * FROM player WHERE USERNAME='$username'");
	$stats = mysqli_fetch_array($getstats);

	if ($stats['DEATHS'] != 0) {
		if ($stats['KILLS'] == 0) {
			$kd = round(1 / $stats['DEATHS'],2);
		} else {
			$kd = round($stats['KILLS'] / $stats['DEATHS'],2);
		}
	} else {
		$kd = $stats['KILLS'];
	}
	$kd = round($kd,2);
	echo $kd;
	$insertkd = mysqli_query($db, "UPDATE player SET KD = $kd WHERE USERNAME='$username'");
	$getnewkd = mysqli_query($db, "SELECT * FROM player WHERE USERNAME='$username'");
	$newkdarr = mysqli_fetch_array($getnewkd);
	$newkd = $newkdarr['KD'];
	echo "<br>" . round($newkd,2);
}
?>