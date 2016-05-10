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
	if ($perpage > 100) {
		$perpage = 100;
	}
/////

	$nav = file_get_contents('header.php');
	$nav = str_replace('<li><a href="stats"', '<li class="active"><a href="stats"', $nav);
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
$gettotalplayers = mysqli_query($db, "SELECT COUNT(DISTINCT WIN_USER) FROM kill_log");
$totalplayers = mysqli_fetch_array($gettotalplayers);
$totalplayers = $totalplayers[0];

$getlist = mysqli_query($db, "SELECT * FROM kill_log ORDER BY DATE_TIME DESC LIMIT $listfirst,$perpage");

$listedkills = $page * $perpage;

$lastpage = ceil($totalkills / $perpage);

if ($page > $lastpage) {
	echo "nope! <meta http-equiv='refresh' content='0,URL=stats?page=" . $lastpage .  "&per=" . $perpage . "'>";
}
if ($listedkills < 1) {
	echo "nope! <meta http-equiv='refresh' content='0,URL=stats?page=1&per=" . $perpage . "'>";
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
<meta http-equiv="refresh" content="30;URL=stats">
	<div class="container text-center">
		<h1>All Stats <small><?php echo $totalkills; ?> Kills by <?php echo $totalplayers; ?> Players!</small></h1>
		<hr style="margin-bottom: 0px;">
		<ul class="pagination btn-group">
			<li<?php echo $firstyn; ?>><a href="stats?page=1&per=<?php echo $perpage; ?>">&laquo;</a></li>
			<li<?php echo $prevyn; ?>><a href="stats?page=<?php echo $prevpage . '&per=' . $perpage; ?>">&#60;</a></li>
			<li class="disabled"><a href="stats?page=<?php echo ceil($page) . '&per=' . $perpage; ?>"><?php echo $page; ?></a></li>
			<li<?php echo $nextyn; ?>><a href="stats?page=<?php echo $nextpage . '&per=' . $perpage; ?>">&#62;</a></li>
			<li<?php echo $lastyn; ?>><a href="stats?page=<?php echo $lastpage . '&per=' . $perpage; ?>">&raquo;</a></li>
		</ul>
		<div class="btn-group">
		  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php echo $perpage; ?> Kills per page <span class="caret"></span>
		  	</button>
		  	<ul class="dropdown-menu" role="menu">
			    <li<?php echo $per1; ?>><a href="stats?page=<? echo $page; ?>&per=25">25</a></li>
			    <li<?php echo $per2; ?>><a href="stats?page=<? echo $page; ?>&per=50">50</a></li>
			    <li<?php echo $per3; ?>><a href="stats?page=<? echo $page; ?>&per=100">100</a></li>
			</ul>
		</div>
		<table class="table table-bordered" style="margin-bottom: 0px;">
			<thead>
				<tr>
					<th width="190px" style="min-width:190px;">Date & Time</th>
					<th>Winner</th>
					<th width="167px">Winner health</th>
					<th>Loser</th>
					<th width="110px" style="min-width:110px;">Kill Weapon</th>
					<!--<th>Arena</th>-->
				</tr>
			</thead>
			<tbody>
				<?php
					while ($list = mysqli_fetch_array($getlist)) {
						$datetimeold = str_replace(" ", " @ ", $list["DATE_TIME"]);

						$year = substr($datetimeold, 0, 4);
						$month = substr($datetimeold, 5, 2);
						$day = substr($datetimeold, 8, 2);
						$time = substr($datetimeold, 12, 9);
						$datetime = $day . "-" . $month . "-" . $year . " @ " . $time;
						$health = 5 * $list['WIN_HEALTH'];
						
						include 'weapon.php';

						echo "<tr>";
						$timeago = new TimeAgo();
						echo "<td data-toggle='popover' data-container='body' data-placement='right' data-content='$datetime' data-trigger='hover'>" . $timeago->inWords($list['DATE_TIME']) . " ago</td><td><a href='player?name=". $list['WIN_USER'] . "'>" . $list["WIN_USER"] . "</a></td><td><div class='hearts h-" . $health . "'></div></td><td><a href='player?name=" . $list["LOSE_USER"] . "'>" . $list["LOSE_USER"] . "</a></td>" . $weapon/* . "<td><a href='arena?name=" . $list['LOCATION'] . "'>" . $list['LOCATION'] . "</a></td>"*/;
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
		<ul class="pagination btn-group">
			<li<?php echo $firstyn; ?>><a href="stats?page=1&per=<?php echo $perpage; ?>">&laquo;</a></li>
			<li<?php echo $prevyn; ?>><a href="stats?page=<?php echo $prevpage . '&per=' . $perpage; ?>">&#60;</a></li>
			<li class="disabled"><a href="stats?page=<?php echo ceil($page) . '&per=' . $perpage; ?>"><?php echo $page; ?></a></li>
			<li<?php echo $nextyn; ?>><a href="stats?page=<?php echo $nextpage . '&per=' . $perpage; ?>">&#62;</a></li>
			<li<?php echo $lastyn; ?>><a href="stats?page=<?php echo $lastpage . '&per=' . $perpage; ?>">&raquo;</a></li>
		</ul>
		<div class="btn-group">
		  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php echo $perpage; ?> Kills per page <span class="caret"></span>
		  	</button>
		  	<ul class="dropdown-menu" role="menu">
			    <li<?php echo $per1; ?>><a href="stats?page=<? echo $page; ?>&per=25">25</a></li>
			    <li<?php echo $per2; ?>><a href="stats?page=<? echo $page; ?>&per=50">50</a></li>
			    <li<?php echo $per3; ?>><a href="stats?page=<? echo $page; ?>&per=100">100</a></li>
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