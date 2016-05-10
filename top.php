<?php
	if (!isset($_GET['page'])) {
	$page = 1;
	} else {
		$page = $_GET['page'];
	}

	if (!isset($_GET['per'])) {
		$perpage = 25;
	} else {
		$perpage = $_GET['per'];
	}

	if (!isset($_GET['by'])) {
		$orderby = "MostELO";
	} else {
		$orderby = $_GET['by'];
	}
	if ($perpage > 100) {
		$perpage = 100;
	}
/////

	$nav = file_get_contents('header.php');
	$nav = str_replace('<li><a href="top"', '<li class="active"><a href="top"', $nav);
	echo $nav;
?>
<?php
$prevpage = ceil($page - 1);
$nextpage = ceil($page + 1);
$listfirst = $prevpage * $perpage;
$listlast = $listfirst + $perpage;

require "db/connect.php";

$gettotalkills = mysqli_query($db, "SELECT COUNT(WIN_USER) FROM kill_log");
$totalkills = mysqli_fetch_array($gettotalkills);
$totalkills = $totalkills[0];

$getallplayers = mysqli_query($db, "SELECT COUNT(DISTINCT USERNAME) FROM player");
$allplayers = mysqli_fetch_array($getallplayers);
$allplayers = $allplayers[0];

///// ORDER BY /////

switch ($orderby) {
	case 'FirstName':
		$orderq = "USERNAME ASC,ELO DESC,KILLS DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'LastName':
		$orderq = "USERNAME DESC,ELO DESC,KILLS DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'LeastELO':
		$orderq = "ELO ASC,KILLS DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'MostKills':
		$orderq = "KILLS DESC,ELO DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'LeastKills':
		$orderq = "KILLS ASC,ELO DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'MostDeaths':
		$orderq = "DEATHS DESC,KILLS DESC,ELO DESC,PLAYTIME ASC";
		break;
	case 'LeastDeaths':
		$orderq = "DEATHS ASC,KILLS DESC,ELO DESC,PLAYTIME ASC";
		break;
	case 'MostKD':
		$orderq = "KD DESC,KILLS DESC,ELO DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'LeastKD':
		$orderq = "KD ASC,KILLS DESC,ELO DESC,DEATHS ASC,PLAYTIME ASC";
		break;
	case 'MostPlaytime':
		$orderq = "PLAYTIME DESC,KILLS DESC,ELO DESC,DEATHS ASC";
		break;
	case 'LeastPlaytime':
		$orderq = "PLAYTIME ASC,KILLS DESC,ELO DESC,DEATHS ASC";
		break;
	default:
		$orderq = "ELO DESC,KILLS DESC,DEATHS ASC,PLAYTIME ASC";
		break;
}

///// -------- /////

$getlist = mysqli_query($db, "SELECT * FROM player ORDER BY $orderq LIMIT $listfirst,$perpage");

$listedkills = $page * $perpage;

$lastpage = ceil($allplayers / $perpage);

if ($page > $lastpage) {
	echo "nope! <meta http-equiv='refresh' content='0,URL=top?page=" . $lastpage .  "&per=" . $perpage . "'>";
}
if ($listedkills < 1) {
	echo "nope! <meta http-equiv='refresh' content='0,URL=top?page=1&per=" . $perpage . "'>";
}

switch ($perpage) {
	default:
		$per1 = " class='active'";
		$per2 = "";
		$per3 = "";
		break;
	case 50:
		$per1 = "";
		$per2 = " class='active'";
		$per3 = "";
		break;
	case 100:
		$per1 = "";
		$per2 = "";
		$per3 = " class='active'";
		break;
}

if ($prevpage < 1) {
	$prevyn = " class='disabled'";
	$firstyn = " class='disabled'";
} else {
	$prevyn = "";
	$firstyn = "";
}
if ($nextpage >= $lastpage) {
	$nextpage = $lastpage;
}
if ($page == $lastpage) {
	$nextyn = " class='disabled'";
	$lastyn = " class='disabled'";
} else {
	$nextyn = "";
	$lastyn = "";
}



require('westsworld.datetime.class.php');
require('timeago.inc.php');
?>
<meta http-equiv="refresh" content="30;URL=top?page=<?php echo $page . '&per=' . $perpage; ?>">
	<div class="container text-center">
		<h1>The Leaderboards <small><?php echo $totalkills; ?> Kills by <?php echo $allplayers; ?> Players!</small></h1>
		<hr style="margin-bottom: 0px;">
		<ul class="pagination btn-group">
			<li<?php echo $firstyn; ?>><a href="top?page=1&per=<?php echo $perpage; ?>&by=<? echo $orderby; ?>">&laquo;</a></li>
			<li<?php echo $prevyn; ?>><a href="top?page=<?php echo $prevpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&#60;</a></li>
			<li class="disabled"><a href="top?page=<?php echo ceil($page) . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>"><?php echo $page; ?></a></li>
			<li<?php echo $nextyn; ?>><a href="top?page=<?php echo $nextpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&#62;</a></li>
			<li<?php echo $lastyn; ?>><a href="top?page=<?php echo $lastpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&raquo;</a></li>
		</ul>
		<div class="btn-group">
		  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php echo $perpage; ?> Players per page <span class="caret"></span>
		  	</button>
		  	<ul class="dropdown-menu" role="menu">
			    <li<?php echo $per1; ?>><a href="top?page=<? echo $page; ?>&per=25&by=<? echo $orderby; ?>">25</a></li>
			    <li<?php echo $per2; ?>><a href="top?page=<? echo $page; ?>&per=50&by=<? echo $orderby; ?>">50</a></li>
			    <li<?php echo $per3; ?>><a href="top?page=<? echo $page; ?>&per=100&by=<? echo $orderby; ?>">100</a></li>
			</ul>
		</div>
		<table class="table table-bordered" style="margin-bottom: 0px;">
			<thead>
				<tr class="sortable">
					<th width="50px">#</th>
					<th width="200px" style="min-width:190px;"><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "FirstName") { echo "LastName"; } else { echo "FirstName"; } ?>" class=<?php if ($orderby == "FirstName" || $orderby == "LastName") { echo "\"btn btn-sm btn-success\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "FirstName") { echo "arrow-down"; } else if ($orderby == "LastName") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> Username</th>
					<th><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "MostELO") { echo "LeastELO"; } else { echo "MostELO"; } ?>" class=<?php if ($orderby == "MostELO") { echo "\"btn btn-sm btn-success\""; } else if ($orderby == "LeastELO") { echo "\"btn btn-sm btn-danger\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "MostELO") { echo "arrow-down"; } else if ($orderby == "LeastELO") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> ELO</th>
					<th><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "MostKills") { echo "LeastKills"; } else { echo "MostKills"; } ?>" class=<?php if ($orderby == "MostKills") { echo "\"btn btn-sm btn-success\""; } else if ($orderby == "LeastKills") { echo "\"btn btn-sm btn-danger\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "MostKills") { echo "arrow-down"; } else if ($orderby == "LeastKills") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> Kills</th>
					<th><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "MostDeaths") { echo "LeastDeaths"; } else { echo "MostDeaths"; } ?>" class=<?php if ($orderby == "MostDeaths") { echo "\"btn btn-sm btn-success\""; } else if ($orderby == "LeastDeaths") { echo "\"btn btn-sm btn-danger\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "MostDeaths") { echo "arrow-down"; } else if ($orderby == "LeastDeaths") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> Deaths</th>
					<th><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "MostKD") { echo "LeastKD"; } else { echo "MostKD"; } ?>" class=<?php if ($orderby == "MostKD") { echo "\"btn btn-sm btn-success\""; } else if ($orderby == "LeastKD") { echo "\"btn btn-sm btn-danger\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "MostKD") { echo "arrow-down"; } else if ($orderby == "LeastKD") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> K/D Ratio</th>
					<th><a href="top?page=<?php echo $page . "&per" . $perpage . "&by="; if ($orderby == "MostPlaytime") { echo "LeastPlaytime"; } else { echo "MostPlaytime"; } ?>" class=<?php if ($orderby == "MostPlaytime") { echo "\"btn btn-sm btn-success\""; } else if ($orderby == "LeastPlaytime") { echo "\"btn btn-sm btn-danger\""; } else { echo "\"btn btn-sm btn-primary\""; } ?>><i class="glyphicon glyphicon-<?php if ($orderby == "MostPlaytime") { echo "arrow-down"; } else if ($orderby == "LeastPlaytime") { echo "arrow-up"; } else { echo "sort"; } ?>"></i></a> Playtime</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rank = 1 + ((ceil($page) - 1) * $perpage);

					while ($list = mysqli_fetch_array($getlist)) {
						if ($list['DEATHS'] != 0) {
							if ($list['KILLS'] == 0) {
								$kd = round(1 / $list['DEATHS'],2);
							} else {
								$kd = round($list['KILLS'] / $list['DEATHS'],2);
							}
						} else {
							$kd = round($list['KILLS'],2);
						}
						$username = $list['USERNAME'];
						$insertkd = mysqli_query($db, "UPDATE player SET KD = $kd WHERE USERNAME='$username'");
						$getnewkd = mysqli_query($db, "SELECT * FROM player WHERE USERNAME='$username'");
						$newkdarr = mysqli_fetch_array($getnewkd);

						$playtime = $list['PLAYTIME'];
						$playhours = round($playtime / 3600);
						if ($playhours >= 24) {
							$playdaysstring = floor($playhours / 24) . " day<br>";
							$playdays = floor($playhours / 24) . "d ";
							$playhours = $playhours - 24;
							if ($playhours >= 48) {
								$playdaysstring = floor($playdays / 24) . " days<br>";
								$playdays = floor($playhours / 24) . "d ";
								$playhours = $playhours - ($playdays * 24);
							}
						} else {
							$playdaysstring = "";
							$playdays = "";
						}
						$playhrr = $playtime % 3600;
						$playminutes = round($playhrr / 60);
						$playminr = $playhrr % 60;
						$playseconds = round($playminr / 60);
						if ($playhours == 1) {
							$playhoursstring = "1 hour<br>";
							$playhours = "1h ";
						} else if ($playhours == 0) {
							$playhoursstring = "";
							$playhours = "";
						} else {
							$playhoursstring = $playhours . " hours<br>";
							$playhours = $playhours . "h ";
						}
						if ($playminutes == 1) {
							$playminutesstring = "1 minute<br>";
							$playminutes = $playminutes . "m";
						} else if ($playminutes == 0) {
							$playminutesstring = "";
							$playminutes = "";
						} else {
							$playminutesstring = $playminutes . " minutes<br>";
							$playminutes = $playminutes . "m ";
						}
						if ($playseconds == 1) {
							$playsecondsstring = "1 second";
							$playseconds = "1s";
						} else if ($playseconds == 0) {
							$playsecondsstring = "";
							$playseconds = "";
						} else {
							$playsecondsstring = $playseconds . " seconds";
							$playseconds = $playseconds . "s";
						}
						$playstring = $playdays . $playhours . $playminutes;
						$fullplaystring = $playdaysstring . $playhoursstring . $playminutesstring;

						if ($rank == 1 && ($orderby == "MostELO" || $orderby == "MostKills" || $orderby == "MostKD")) {
							echo "<tr class=\"warning\">";
						} else if ($rank == 2 && ($orderby == "MostELO" || $orderby == "MostKills" || $orderby == "MostKD")) {
							echo "<tr class=\"active\">";
						} else if ($rank == 3 && ($orderby == "MostELO" || $orderby == "MostKills" || $orderby == "MostKD")) {
							echo "<tr style=\"background-color:#F9EFE6;\">";
						} else {
							echo "<tr>";
						}
						
						echo "<td>" . $rank . "</td>" . "<td><a href='player?name=" . $list['USERNAME'] . "'>" . $list['USERNAME'] . "</a></td>" . "<td>". $list['ELO'] . "</td><td>" . $list["KILLS"] . "</td><td>" . $list['DEATHS'] . "</td><td>" . round($list['KD'],2) . "</td><td data-toggle=\"popover\" data-container=\"body\" data-placement=\"left\" data-trigger=\"hover\" data-html=\"true\" data-title=\"Playtime:\" data-content=\"" . $fullplaystring . "\">" . $playstring . "</td>";
						echo "</tr>";

						$rank++;
					}
				?>
			</tbody>
		</table>
		<ul class="pagination btn-group">
			<li<?php echo $firstyn; ?>><a href="top?page=1&per=<?php echo $perpage; ?>&by=<? echo $orderby; ?>">&laquo;</a></li>
			<li<?php echo $prevyn; ?>><a href="top?page=<?php echo $prevpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&#60;</a></li>
			<li class="disabled"><a href="top?page=<?php echo ceil($page) . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>"><?php echo $page; ?></a></li>
			<li<?php echo $nextyn; ?>><a href="top?page=<?php echo $nextpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&#62;</a></li>
			<li<?php echo $lastyn; ?>><a href="top?page=<?php echo $lastpage . '&per=' . $perpage; ?>&by=<? echo $orderby; ?>">&raquo;</a></li>
		</ul>
		<div class="btn-group">
		  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php echo $perpage; ?> Kills per page <span class="caret"></span>
		  	</button>
		  	<ul class="dropdown-menu" role="menu">
			    <li<?php echo $per1; ?>><a href="top?page=<? echo $page; ?>&per=25&by=<? echo $orderby; ?>">25</a></li>
			    <li<?php echo $per2; ?>><a href="top?page=<? echo $page; ?>&per=50&by=<? echo $orderby; ?>">50</a></li>
			    <li<?php echo $per3; ?>><a href="top?page=<? echo $page; ?>&per=100&by=<? echo $orderby; ?>">100</a></li>
			</ul>
		</div>
	</div>
	<?php include 'footer.php'; ?>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script>
		$(function(){
				$("[data-toggle='popover']").popover();
			});
	</script>
</body>
</html>

