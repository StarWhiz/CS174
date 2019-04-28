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
            <form class="uploadform" method='post' action='index.php' enctype='multipart/form-data'>
                Please enter a string:
                <input type="text" name="enteredString">
                <br>
                Then, please upload a .txt File:
                <input type='file' name='fileUpload' id='fileID'/>
                <input type='submit' name="fileSubmit" value='Upload' class="uploadButton">
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
                #echo "This file is not a txt file. Please try uploading again...";
                echo '<p class="uploaderror">This file is not a txt file. Please try uploading again...</p>';
            }
        }
        //TODO Display user's uploads.
        printUserContent($_SESSION['userId'], $conn);
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
        echo '<p class="uploaderror">File upload failed!</p>';
        die('execute() failed: ' . $conn->error);
    }
    else {
        echo '<p class="uploadsuccess">File upload was successful!</p>';
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

function printUserContent($userID, $conn) {
    $sql = "SELECT stringContent, textFile FROM userContent WHERE idUsers='$userID'";
    $resultCheck = $conn->query($sql);
    if (!$resultCheck) {
        echo '<p class="uploaderror">Problem loading userData</p>';
        die('execute() failed: ' . $conn->error);
    }

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<h2>User Uploaded Content</h2>';
    echo '<br>';
    echo '<table>';
    echo "<tr><th>String</th><th>FileContents</th></tr>";
    while ($row = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC)) {

        $string = $row['stringContent'];
        $file = $row['textFile'];

        echo "<tr><td>$string</td>";
        echo "<td>$file</td>";
        echo "</tr>";
    }
    echo '</table>';

}

// SQL Create Tables I already did on the sql server...
/*
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    uidUsers TINYTEXT NOT NULL,
    emailUsers TINYTEXT NOT NULL,
    pwdUsers TINYTEXT NOT NULL
);
*/

/*
DROP TABLE IF EXISTS userContent;
CREATE TABLE userContent (
uploadNum int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUsers int(11) NOT NULL,
stringContent TINYTEXT NOT NULL,
textFile TEXT
);
 */



