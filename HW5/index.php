<?php
    require_once "header.php";
    require_once 'database_inc.php';

echo <<< END
<main>
    <div class="wrapper-main">
        <section class="section-default">
END;

    if (isset($_SESSION['userId'])) { //CASE: User is logged in...
        printLoggedInForms();
        listenEnglishUpload($conn);
        listenTranslateUpload($conn);

        //printUserContent($_SESSION['userId'], $conn);
    }
    else {
        if(isset($_GET["error"])) {
            if ($_GET["error"] == "emptyfields") {
                echo '<p class="signuperror">Can\'t login. Either username and/or password fields were empty...</p><br>';
                printDefaultForms();
            }
            else if ($_GET["error"] == "wrongpwd") {
                echo '<p class="signuperror">Can\'t login. Password or username Is Incorrect...</p><br>';
                printDefaultForms();
            }
            else if ($_GET["error"] == "nouser") {
                echo '<p class="signuperror">Can\'t login. Username does not exist!</p><br>';
                printDefaultForms();
            }
        }
        else { // CASE: Default... Default Model, User is not logged in..........................................
            printDefaultForms();
        }
    }

echo <<< END
        </section>
    </div>
</main>
END;

function printLoggedInForms() {
    echo <<< END
        <body>
            <h1>Welcome back! You are logged in.</h1><br><br>
            <form method='post' action='index.php' enctype='multipart/form-data' id="translateForm">
                <textarea rows="8" cols="75" name="texttotranslate" form="translateform"> Enter text to translate here...</textarea>
                <br>
                <div align="center">
                    <input type='submit' name="translateText" value='Submit Translation' class="uploadButton">
                </div>
            </form>
            <br><br><br><br><br><br>
            <h4>To use your own translation model. Please upload two files. One containing english words and the 
            other containing the translation. After this the translator will use your model instead of the default.</h4>
            <br>
            <form class="uploadform" method='post' action='index.php' enctype='multipart/form-data' id="uploadform">
                <br>
                Upload a .txt file containing english words:
                <input type='file' name='fileUpload' id='fileID'/>
                <input type='submit' name="fileSubmit" value='Upload' class="uploadButton">
                <br><br>
                Upload a .txt file containing it's translation:
                <input type='file' name='fileUpload' id='fileID'/>
                <input type='submit' name="fileSubmit" value='Upload' class="uploadButton">
            </form>
        </body>        
END;
}

function printDefaultForms() {
    $translateResult = "Translated text appears here.";

    if(isset($_POST["translateTextDefault"])) {
        $translateResult = "there was no spoon";
    }

    echo <<< END
    <body>
        <h1>Welcome to the lame translator!</h1><br><br>
        <form method='post' action='index.php' enctype='multipart/form-data' id="translateForm">
            <textarea rows="8" cols="75" name="texttotranslate" form="translateform"> Enter text to translate here...</textarea>
            <br>
            <div align="center">
                <input type='submit' name="translateTextDefault" value='Submit Translation' class="uploadButton">
            </div>
        </form>
        <br>
        <textarea rows="8" cols="75">$translateResult</textarea>
    </body>
END;

}

function listenEnglishUpload ($conn) {
    if(isset($_POST["englishSubmit"])) {
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
        // $conn -> close(); // TODO: Do i need this here?
    }
}

function listenTranslateUpload ($conn) {

}

function saveUserContentToDB ($string, $file, $conn) {
    $fileSanitized = sanitizeMySQL($conn, $file); # sanitize file contents
    $userID = $_SESSION['userId'];

    $sql = "INSERT INTO userContent VALUES(NULL,'$userID', '$string', '$fileSanitized')";

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
    echo "<tr><th>Content Name</th><th>File Content</th></tr>";
    while ($row = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC)) {

        $string = $row['stringContent'];
        $htmlRdyString = htmlentities($string);
        $file = $row['textFile'];
        $htmlRdyFile = htmlentities($file);

        echo "<tr><td>$htmlRdyString</td>";
        echo "<td>$htmlRdyFile</td>";
        echo "</tr>";
    }
    echo '</table>';
    $conn -> close(); //TODO: make sure this doesnt break anything
}
