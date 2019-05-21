<?php
    require_once "header.php";
    require_once 'database_inc.php';

echo <<< END
<main>
    <div class="wrapper-main">
        <section class="section-default">
END;

    if (isset($_SESSION['userId'])) { //CASE: User is logged in...
        $userID = $_SESSION['userId'];
        printLoggedInForms($conn, $userID);
        listenUpload($conn);
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

function printLoggedInForms($conn, $userID) {
    $translateResult = "Translated text appears here.";
    if(isset($_POST["submitSourceTxtV2"])) {
        $source = $_POST["sourceTxtToTranslateV2"];
        $useUserModel = translateWithWhichModel($conn, $userID);
        if ($useUserModel) {
            //$translateResult = translateWithUserModel($source, $userID, $conn);
        }
        else
            $translateResult = translateWithDefaultModel($source);
        }

    echo <<< END
        <body>
            <h1>Welcome back! You are logged in.</h1><br><br>
            <h4>Input: </h4>
            <form method='post' action='index.php' enctype='multipart/form-data' id="translateForm">
                <textarea name="sourceTxtToTranslateV2" rows="8" cols="75">Enter English text to translate here...</textarea> 
                <br>
                <div align="center">
                    <input type="submit" name="submitSourceTxtV2" value="Submit Translation" class="uploadButton">
                </div>
            </form>
            <h4>Output: </h4>
            <textarea rows="8" cols="75">$translateResult</textarea>
        
            <br><br><br><br><br><br>
            <h4>To use your own translation model. Please upload two files. One containing english words and the 
            other containing the translation. After this the translator will use your model instead of the default.</h4>
            <br>
            <form class="uploadform" method='post' action='index.php' enctype='multipart/form-data' id="uploadform">
                <br>
                Choose a .txt file containing english words:
                <input type='file' name='fileUpload1' id='fileID'/>
                <br><br>
                Choose a .txt file containing it's translation:
                <input type='file' name='fileUpload2' id='fileID'/>
                <input type='submit' name="uploadTxtFiles" value='Upload' class="uploadButton">
            </form>
        </body>        
END;

}


function printDefaultForms() {
    $translateResult = "Translated text appears here.";
    if(isset($_POST["submitSourceTxt"])) {
        $source = $_POST["sourceTxtToTranslate"];
        $translateResult = translateWithDefaultModel($source);
    }

    echo <<< END
    <body>
        <h1>Welcome to the lame translator!</h1>
        <h4>This translates from English to Latin by default.</h4>
        <br><br>
        <h4>Input: </h4>
        <form method='post' action='index.php' enctype='multipart/form-data' id="translateForm">
            <textarea name="sourceTxtToTranslate" rows="8" cols="75">Enter English text to translate here...</textarea> 
            <br>
            <div align="center">
                <input type="submit" name="submitSourceTxt" value="Submit Translation" class="uploadButton">
            </div>
        </form>
        
        <h4>Output: </h4>
        <textarea rows="8" cols="75">$translateResult</textarea>
    </body>
END;
}


function translateWithDefaultModel ($source) {
    $english_fp = "english.txt";
    $latin_fp = "latin.txt";
    $englishString = "";
    $latinString = "";
    if (file_exists($english_fp)){
        $englishString = file_get_contents($english_fp);
    }
    else {
        echo "The file $english_fp does not exist!";
    }
    if (file_exists($latin_fp)){
        $latinString = file_get_contents($latin_fp);

    }
    else {
        echo "The file $latin_fp does not exist!";
    }
    $sanitizedSource = sanitizeString($source);
    $translationOutput = "";

    // Split strings into array with explode
    $englishStringArray = explode("\r\n", $englishString);
    //print_r($englishStringArray);
    $latinStringArray = explode("\r\n", $latinString);
    $arraySource = explode(" ", $sanitizedSource);

    $dictionary = array_combine($englishStringArray,$latinStringArray);

    for ($i = 0; $i < sizeof($arraySource); $i++){
        if (array_key_exists($arraySource[$i], $dictionary)) {
            $translationOutput = $translationOutput . "" . $dictionary[$arraySource[$i]] . " ";
        }
        else {
            $translationOutput = $translationOutput.$arraySource[$i]. " ";
        }
    }
    return $translationOutput;
}

/*
function translateWithUserModel ($source, $userID, $conn) {
    $uploadNum = "";
    $sql = "SELECT * WHERE idUsers='$userID'";
    $resultCheck = $conn->query($sql);
    if (!$resultCheck) {
        echo '<p class="uploaderror">Problem loading userData</p>';
        die('execute() failed: ' . $conn->error);
    }
    while ($row = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC)) {
        $uploadNum = $row['uploadNum'];
    }
    if ($uploadNum == NULL) {
        return false;
    }
    else {
        return true;
    }
}*/

function translateWithWhichModel ($conn, $userID) {
    $sql = "SELECT * WHERE idUsers='$userID'";
    $resultCheck = $conn->query($sql);
    if (!$resultCheck) {
        return false;
        echo '<p class="uploaderror">Problem loading userData</p>';
        die('execute() failed: ' . $conn->error);
    }
    else {
        return true;
    }
}

function listenUpload ($conn) {
    if(isset($_POST["uploadTxtFiles"])) {
        $maxFileSize = 65500; # ~64KB max size of TEXT

        if ($_FILES['fileUpload1']['type'] == 'text/plain' && $_FILES['fileUpload2']['type'] == 'text/plain' ){
            // Check if file Uploaded is a .txt file

            if ($_FILES['fileUpload1']['size'] <= $maxFileSize && $_FILES['fileUpload2']['size'] <= $maxFileSize) {
                // Check if file is less than 64KB. If success do below...
                $theFile1 = file_get_contents($_FILES['fileUpload1']['tmp_name']);
                $theFile2 = file_get_contents($_FILES['fileUpload2']['tmp_name']);
                saveUserContentToDB($theFile1, $theFile2, $conn); # File sanitation done in function
            }
            else {
                echo "This file is too large. Please try uploading again with a txt file less than 64KB...";
            }
        }
        else {
            #echo "This file is not a txt file. Please try uploading again...";
            echo '<p class="uploaderror">This file is not a txt file. Please try uploading again...</p>';
        }
        $conn -> close();
    }
}

function saveUserContentToDB ($file1, $file2, $conn) {
    $file1Sanitized = sanitizeMySQL($conn, $file1); # sanitize file contents
    $file2Sanitized = sanitizeMySQL($conn, $file2); # sanitize file contents
    $userID = $_SESSION['userId'];

    $sql = "INSERT INTO usercontent VALUES(NULL,'$userID', '$file1Sanitized', '$file2Sanitized')";

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
