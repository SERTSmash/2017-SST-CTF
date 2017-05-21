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

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $leaders = mysqli_real_escape_string($conn, $_POST['leaders']);
    $strengths = mysqli_real_escape_string($conn, $_POST['strengths']);
    $weaknesses = mysqli_real_escape_string($conn, $_POST['weaknesses']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    if (!$name) {
        $err = TRUE;
    }

    if (!$number) {
        $err = TRUE;
    }

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
        $err = TRUE;
    }

    try {
        if (isset($_FILES['file'])) {
            if (!isset($_FILES['file']['error']) ||
                is_array($_FILES['file']['error'])
            ) {
                throw new RuntimeException('An error has occured.');
            }
            switch ($_FILES['file']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('An error has occured.');
            }
#            if ($_FILES['file']['size'] > 10000000) {
#                throw new RuntimeException('Exceeded filesize limit.');
#            }
            $file_name = time().'_'.basename($_FILES['file']['name']);
            $target_path = 'img/upload/'.$file_name;
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                strtolower($finfo->file($_FILES['file']['tmp_name'])),
                array(
                    '.png' => 'image/png',
                    '.PNG' => 'image/PNG',
                    '.jpg' => 'image/jpeg',
                    '.jpeg' => 'image/jpeg',
                    '.JPG' => 'image/jpeg',
                    '.JPEG' => 'image/jpeg',
                ),
                true
            )) {
                throw new RuntimeException('Only .png and jpeg files can be uploaded');
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                exec("convert -define jpeg:size=200x200 $target_path -thumbnail 390x290^ -gravity center -extent 390x290 $target_path");
                $message = basename($_FILES['file']['name'])." has been uploaded.";
            } else {
                throw new RuntimeException('Failed to move file');
            }

            
        } 
    } catch (RuntimeException $e) {
        $err = TRUE;
        $message = $e->getMessage();
        echo $message;
    } 

    $sql = "INSERT INTO pit_scout (name, number, leaders, strengths, weaknesses, notes, image) VALUES ('$name', '$number', '$leaders', '$strengths', '$weaknesses', '$notes', '$target_path')";

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
    <h3>Robot Addition Form</h3>
    <fieldset>
      <input placeholder="Team Name" name="name" type="text" tabindex="1" required autofocus>
    </fieldset>
    <fieldset>
      <input placeholder="Team Number" name="number" type="number" min="0" tabindex="2" required>
    </fieldset>
    <fieldset>
      <textarea placeholder="List Leaders" name="leaders" tabindex="3"></textarea>
    </fieldset>
    <fieldset>
      <textarea placeholder="Robot Strengths" name="strengths" tabindex="4"></textarea>
    </fieldset>
    <fieldset>
      <textarea placeholder="Robot Weaknesses" name="weaknesses" tabindex="5"></textarea>
    </fieldset>
    <fieldset>
      <textarea placeholder="Other Notes" name="notes" tabindex="6"></textarea>
    </fieldset>
    <fieldset>
      <p><b>Robot Image (png/jpg)</b></p>
      <input name="file" type="file" tabindex="7" accept="image/*" required>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
    </fieldset>
  </form>
</div>
</body>
