<?php include 'header.php'; ?>
		<div class="container text-center">
		<h1>Making a new arena!</h1>
		<hr>
			<form action="upload.php" method="post" class="col-sm-4 col-md-offset-4" enctype="multipart/form-data">
				<label for="arena">Arena Name</label>
				<input type="text" class="form-control" name="arena" <?php if (isset($_GET['map'])) { echo "value=\"" . $_GET['map'] . "\""; } ?> required>
				<hr>
				<label for="file">Image(s):</label>
				<div id="files">
					<div id="clonable">
						</p>
						<input type="file" class="btn btn-info form-control" name="uploadedfile[]" id="file">
					</div><a onclick="addFile();" style="position:absolute;left:370px;top:135px;" class="btn btn-primary">+</a>
				</div>
				<hr>
				<input type="submit" class="btn btn-success" name="submit" value="Submit">
			</form>
		</div>
	</body>
	<?php include 'footer.php'; ?>
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