<?php include 'header.php'; ?>
        <div class="container text-center">
        <h1>Making a new arena!</h1>
        <hr>
            <?php
            function reArrayFiles(&$file_post) {

                $file_ary = array();
                $file_count = count($file_post['name']);
                $file_keys = array_keys($file_post);

                for ($i=0; $i<$file_count; $i++) {
                    foreach ($file_keys as $key) {
                        $file_ary[$i][$key] = $file_post[$key][$i];
                    }
                }

                return $file_ary;
            }

            if ($_FILES['uploadedfile']) {
                $file_ary = reArrayFiles($_FILES['uploadedfile']);

                foreach ($file_ary as $file) {
                    
                    $arenaname = $_POST['arena'];

                    if(!file_exists("uploads/" . $arenaname)) {
                        mkdir("uploads/" . $arenaname,0700);
                    }
                    
                    $target_path = "uploads/" . $arenaname . "/";
                    $target_path = $target_path . basename( $file['name']); 
                    if(!file_exists($target_path)) {
                        if(move_uploaded_file($file['tmp_name'], $target_path)) {
                            echo "The file <b>".  basename( $file['name']). 
                            "</b> has been uploaded to <u>" . $target_path;
                            echo "</u>     File Size: " . $file['size'] . "<br>";
                        } else {
                            echo "There was an error uploading the file, please try again later!";
                        }
                    } else {
                        echo "File (<b>" . $file['name'] . "</b>) already existed! Upload canceled<br>";
                    }
                    
                echo "<meta http-equiv='refresh' content='3;URL=uploads.php?map=" . $_POST['arena'] . "'>";
                }
            } else {
                echo "No images uploaded!";
            }

            ?>            
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
