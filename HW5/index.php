<?php
    require "header.php";
    require "footer.php";
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
            $userString = $_POST['enteredString']; // String Input From User

            if ($_FILES['fileUpload']['type'] == 'text/plain'){ // Check if file Uploaded is a .txt file
                echo "This file is a txt file...";
                $theFile = file_get_contents($_FILES['fileUpload']['tmp_name']);
                echo $theFile;
                saveTxtFileToDB($theFile);

            }
            else {
                echo "This file is not a txt file. Please try uploading again...";
            }

            echo $userString;
            saveStringToDB($userString);
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
function saveStringToDB ($string) {
    #TODO write string to database.
}

function saveTxtFileToDB ($file) {
    #TODO save file to database
}

                        



/*
CREATE TABLE users (
    idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    uidUsers TINYTEXT NOT NULL,
    emailUsers TINYTEXT NOT NULL,
    pwdUsers LONGTEXT NOT NULL
);
*/




