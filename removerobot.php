<?php

include 'password.php';

if(isset($_POST['submit'])) {

    $err = FALSE;
    $message = '';
    $target_path = '';

    $servername = 'localhost';
    $username = 'www';
    $dbname = 'robotics';

    $conn = new mysqli($servername, $username, $password, $dbname);

    $number = mysqli_real_escape_string($conn, $_POST['number']);

    if (!$number) {
        $err = TRUE;
    }

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
        $err = TRUE;
    }

    $sql = "DELETE FROM pit_scout WHERE (number='$number') LIMIT 1";

    if ($err || $conn->query($sql) === FALSE) {
        echo 'Error' . $sql . $conn->error;
    }

    $conn->close();
} 

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="css/form.css">
</head>
</body>
<div class="container">
  <form id="contact" action="" method="post" enctype="multipart/form-data">
    <h3>Robot Removal Form</h3>
    <feildset>
      <input placeholder="Team Number" name="number" type="number" min="0" tabindex="2" required>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-delete" data-delete="...Deleting">Delete</button>
    </fieldset>
  </form>
</div>
</body>
