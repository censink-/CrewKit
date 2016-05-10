<?php
	$nav = file_get_contents('header.php');
	$nav = str_replace('<li><a href="arena"', '<li class="active"><a href="arena"', $nav);
	echo $nav;
?>
<div class="container text-center">
		<?php
			require "db/connect.php";

			if (isset($_POST['inputName'])) {
				echo "<meta http-equiv='refresh' content='0;URL=arena?name=" . $_POST['inputName'] . "'>";
			}
			if (!isset($_GET['name']) || $_GET['name'] == "") {
		?>
		<h1>Invalid arena! <small>Enter one to continue</small></h1>
		<hr>
		<form action="arena.php" method="post">
			<input required type="text" class="form-control" style="width:200px;display:inline;" name="inputName"> <button class="btn btn-success" style="margin-top:-3px;" type="submit">Go!</button>
		</form>
		<?php
			} else {

				$mapname = $_GET['name'];
				$getname = mysqli_query($db, "SELECT * FROM kill_log WHERE LOCATION='$mapname' LIMIT 1");
				$name = mysqli_fetch_array($getname);
				if ($name['LOCATION'] != $mapname) {
					die("<meta http-equiv='refresh' content='0;URL=arena?name=" . $name['LOCATION'] . "'>");
				};

				echo '<h1>' . $mapname . '\'s stats!</h1>';

				$getkills = mysqli_query($db, "SELECT COUNT('WIN_USER') FROM kill_log WHERE LOCATION='$mapname'");
				$kills = mysqli_fetch_array($getkills);

				$getstats = mysqli_query($db, "SELECT * FROM kill_log WHERE LOCATION='$mapname'");
				$stats = mysqli_fetch_array($getstats);

				$getuniquekillers = mysqli_query($db, "SELECT COUNT(DISTINCT WIN_USER) FROM kill_log WHERE LOCATION='$mapname'");
				$uniquekillers = mysqli_fetch_array($getuniquekillers);

				$getuniqueweapons = mysqli_query($db, "SELECT COUNT(DISTINCT WEAPON) FROM kill_log WHERE LOCATION='$mapname'");
				$uniqueweapons = mysqli_fetch_array($getuniqueweapons);
		?>
		
		<hr>
			<div class="col-sm-3">
				<ul class="nav nav-pills nav-stacked">
					<li class="active"><a href="#stats" data-toggle="tab"><i class="glyphicon glyphicon-stats"></i> Stats</a></li>
					<li><a href="#pics" data-toggle="tab"><i class="glyphicon glyphicon-picture"></i> Pictures</a></li>
				</ul>
				<br>
				<ul class="list-group text-left">
					<li class="list-group-item"><b>Kills:</b> <span class="label label-info"><?php echo $kills[0]; ?></span></li>
					<li class="list-group-item"><b>Unique Killers:</b> <span class="label label-info"><?php echo $uniquekillers[0]; ?></span></li>
					<li class="list-group-item"><b>Unique Weapons:</b> <span class="label label-info"><?php echo $uniqueweapons[0]; ?></span></li>
				</ul>
			</div>
			<div class="col-sm-9">
				<div class="tab-content">
					<div id="stats" class="tab-pane fade in active">
						<div class="panel panel-default">
							<div class="panel-heading">
								Recent encounters:
							</div>
							<div class="panel-body">
								Here's a list of the latest 25 pvp encounters on <?php echo $mapname; ?>!
							</div>
							<table class="table table-bordered" style="margin-bottom:0px;min-width:820px;">
								<thead>
									<tr class="active">
										<th width="165px" style="min-width:165px;">Date & Time</th>
										<th>Winner</th>
										<th width="167px">Winner health</th>
										<th>Loser</th>
										<th width="80px" style="min-width:80px;">Weapon</th>
									</tr>
								</thead>
								<tbody>
								<?php
									require('westsworld.datetime.class.php');
									require('timeago.inc.php');

									$getpvplog = mysqli_query($db, "SELECT * FROM kill_log WHERE LOCATION='$mapname' ORDER BY DATE_TIME DESC LIMIT 25");
									while ($list = mysqli_fetch_array($getpvplog)) {
										$datetimeold = str_replace(" ", " @ ", $list["DATE_TIME"]);

										$year = substr($datetimeold, 0, 4);
										$month = substr($datetimeold, 5, 2);
										$day = substr($datetimeold, 8, 2);
										$time = substr($datetimeold, 12, 9);
										$datetime = $day . "-" . $month . "-" . $year . " @ " . $time;
										$health = 5 * $list['WIN_HEALTH'];
										$winner = "<a href=\"player?name=" . $list['WIN_USER'] . "\">" . $list['WIN_USER'] . "</a>";
										$loser = "<a href=\"player?name=" . $list['LOSE_USER'] . "\">" . $list['LOSE_USER'] . "</a>";

										include 'weapon.php';
										
										$timeago = new TimeAgo();

										echo "<tr>";
										echo "<td data-toggle='popover' data-container='body' data-placement='right' data-content='$datetime' data-trigger='hover'>" . $timeago->inWords($list['DATE_TIME']) . " ago</td><td>" . $winner . "</td><td><div class='hearts h-" . $health . "'></div></td><td>" . $loser . "</td>" . $weapon;
										echo "</tr>";
													}
										echo '
								</tbody>
							</table>';
								?>
						</div>
				</div>
				<div id="pics" class="tab-pane fade in">
					<h3>Gallery of <?php echo $mapname; } ?></h3>
					<hr>
				</div>
			</div>
		<br>
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