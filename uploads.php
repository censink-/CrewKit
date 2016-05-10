<?php include 'header.php'; ?>
        <div class="container text-center">
	        <h1>Images from <?php if(isset($_GET['map'])) { echo "the map " . $_GET['map'] . ". <a href=\"newmap?map=" . $_GET['map'] . "\" class=\"btn btn-primary\">Upload more!</a>"; } else { echo "unavailable map!"; } ?></h1>
	        <hr> 
	        <div class="col-sm-6 col-sm-offset-3">
		        <?php 
				if(isset($_GET['map'])) {
					if(!file_exists("uploads/" . $_GET['map'])) {
						die("Folder doesn't exist!");
					} else {
						if($_GET['map'] == "") {
							echo "No access to main folder!";
						} else {
							$dir = "uploads/" . $_GET['map'];

							// Sort in ascending order - this is default
							$a = scandir($dir);
						}
					}
				} else {
					echo "No folder specified!";
				}

				?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>FileName</th>
							<th>Preview</th>
							<th width="65px;">Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($a as $file) {
							if ($file != "." && $file != ".." && $file != ".DS_Store") {
							echo "<tr>";
							echo "<td>" . $file . "</td>";
							echo "<td><img style=\"max-height:200px;\" src=\"uploads/" . $_GET['map'] . "/" . $file . "\"></td>";
							echo "<td><a class=\"btn btn-danger\" href=\"deleteupload?map=" . $_GET['map'] . "&file=" . $file . "\"><i class=\"glyphicon glyphicon-trash\"></i></a></td>";
							echo "</tr>";
							}
						}
						?>
					</tbody>
				</table>   
			</div>      
        </div>
	<?php include 'footer.php'; ?>
    </body>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script>
        function addFile() {
        var file=document.getElementById("clonable");
        var clone=file.cloneNode(true);
        document.getElementById("files").appendChild(clone);
    }
    </script>
</html>

