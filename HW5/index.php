<?php
    require "header.php";
    require "footer.php";
    require 'database_inc.php';
?>


<!DOCTYPE html>
<main>
    <div class="wrapper-main">
        <section class="section-default">


<?php
    if (isset($_SESSION['userId'])) {
        echo <<< END
        <body>
            <h1>Welcome to the site!</h1><br><br>
            <form method='post' action='index.php' enctype='multipart/form-data'>
                Please enter a string:
                <input type="text" name="enteredString">
                <br>
                Then, please upload a .txt File:
                <input type='file' name='fileUpload' id='fileUpload'>
                <input type='submit' name="fileSubmit" value='Upload'>
            </form>
        </body>        
END;
        if(isset($_POST["fileSubmit"])) {
            $maxFileSize = 65500; # ~64KB max size of TEXT

            if ($_FILES['fileUpload']['type'] == 'text/plain'){
            // Check if file Uploaded is a .txt file

                if ($_FILES['fileUpload']['size'] <= $maxFileSize) {
                // Check if file is less than 64KB. If success do below...
                    $theString = sanitizeString($_POST['enteredString']);
                    $theFile = file_get_contents($_FILES['fileUpload']['tmp_name']);
                    saveUserContentToDB($theString, $theFile, $conn); # File sanitation done in function
                }
                else {
                    echo "This file is too large. Please try uploading again with a txt file less than 64KB...";
                }
            }
            else {
                echo "This file is not a txt file. Please try uploading again...";
            }
        }
    }
    else {
        if(isset($_GET["error"])) {
            if ($_GET["error"] == "emptyfields") {
                echo '<p class="signuperror">Can\'t login. Either username and/or password fields were empty...</p>';
            }
            else if ($_GET["error"] == "wrongpwd") {
                echo '<p class="signuperror">Can\'t login. Password or username Is Incorrect...</p>';
            }
        }
        else {
            echo '<p class = "login-status">Status: Not Logged In</p>';
        }

    }
?>


        </section>
    </div>
</main>


<?php
function saveUserContentToDB ($string, $file, $conn) {
    $file = sanitizeMySQL($conn, $file); # sanitize file contents
    $userID = $_SESSION['userId'];

    $sql = "INSERT INTO userContent VALUES(NULL,'$userID', '$string', '$file')";

    $resultCheck = $conn->query($sql);
    if (!$resultCheck) {
        die('execute() failed: ' . $conn->error);
    }
    else {
        echo <<< END
        <p class="uploadsuccess">File upload was successful!</p>
END;

    }

}
function sanitizeString($var) {
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function sanitizeMySQL($connection, $var) {
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}



/*
CREATE TABLE users (
    idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    uidUsers TINYTEXT NOT NULL,
    emailUsers TINYTEXT NOT NULL,
    pwdUsers TINYTEXT NOT NULL
);
*/




