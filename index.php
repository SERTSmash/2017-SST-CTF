<?php
    include 'password.php';

    $return_arr = array();
    $index = 0;
    $err = FALSE;

    $servername = 'localhost';
    $username = 'www';
    $dbname = 'robotics';

    $conn = new mysqli($servername, $username, $password, $dbname);

    $result = mysqli_query($conn, "SELECT * FROM pit_scout");

    if (!$result) {
        $err = TRUE;
                exit();
            }

            while ($row = mysqli_fetch_array($result)) {
                $row_array['name'] = $row['name'];
                $row_array['number'] = $row['number'];
                $row_array['leaders'] = $row['leaders'];
                $row_array['strengths'] = $row['strengths'];
                $row_array['weaknesses'] = $row['weaknesses'];
                $row_array['notes'] = $row['notes'];
                $row_array['image'] = $row['image'];

                array_push($return_arr, $row_array);
            }
        ?>


        <!DOCTYPE html>
        <html>
            <script>
                var test = document.getElementById("id0");

                function whatClicked(evt) {
                    alert(evt.target.id);
                }
            </script>
            <title>Pit Scouting Database</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/stylesheet.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
            <style>
        body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
        .w3-bar-block .w3-bar-item {padding:20px}
            </style>
            <body>
                <!-- Top menu -->
                <div class="w3-top header-color">
                    <div class="w3-white w3-xlarge" style="max-width:100%;margin:auto;background-color:#604af4">
                        <div class="w3-center w3-padding-16" style="background-color:#c1cadd"><strong>Pit Scouting Database</strong>
                </div>    
                </div>
                </div>

        <!-- !PAGE CONTENT! -->
        <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
            <!-- First Photo Grid-->
            <div class="w3-row-padding w3-padding-16 w3-center" id="food">
            <?php foreach ($return_arr as $value): ?> 
                <div class="w3-quarter">
                    <input onclick="document.getElementById('id<?php echo $index;?>').style.display='block'" type="image" src="<?php echo $value['image']?>" name="saveForm" class="w3-btn w3-border w3-round-large" style="height: 95%; width: 95%;">

                    <h3><?php echo $value['name']?></h3>
                    <p>(<?php echo $value['number']?>)</p>
                    <div class="w3-container">
                      <div id="id<?php echo $index;?>" class="w3-modal">
                        <div class="w3-modal-content w3-animate-bottom">
                          <div class="w3-container w3-animate-bottom">
                            <span test.addEventListener("click", whatClicked, false); onclick="document.getElementById('id<?php echo $index;?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <p><strong>Team:</strong><br><?php echo $value['name'];?></p>
                            <p><strong>Number:</strong><br><?php echo $value['number'];?></p>
                            <p><strong>Leaders:</strong><br><?php echo $value['leaders'];?></p>
                            <p><strong>Weaknesses:</strong><br><?php echo $value['weaknesses'];?></p>
                            <p><strong>Strengths:</strong><br><?php echo $value['strengths'];?></p>
                            <p><strong>Notes:</strong><br><?php echo $value['notes'];?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            <?php ++$index; endforeach; ?>

                <div class="w3-quarter">
                    <input onClick="location.href = 'http://sstctf.org/Robot-Logging/addrobot.php';" type="image" src="img/plus.jpg" name="saveForm" class="w3-btn w3-border w3-round-large" style="height: 95%; width: 95%;" >
                    <h3>Add Robot</h3>
                </div>
                <div class="w3-quarter">
                    <input onclick="location.href = 'http://sstctf.org/Robot-Logging/removerobot.php';" type="image" src="img/minus.png" name="saveForm" class="w3-btn w3-border w3-round-large" style="height: 95%; width: 95%;" >
                    <h3>Remove Robot</h3>
                </div>

            </div>
            <!-- Pagination -->
            <hr id="about">

            <!-- Footer -->
            <footer class="w3-row-padding w3-padding-32" style="text-align: center">
                    Powered by <a href="http://sstctf.org">SSTCTF</a>
            </footer>

            <!-- End page content -->
        </div>

        <script>
// Script to open and close sidebar
//function w3_open() {
//    document.getElementById("mySidebar").style.display = "block";
//}
//
//function w3_close() {
//    document.getElementById("mySidebar").style.display = "none";
//}
        </script>

    </body>
</html>
