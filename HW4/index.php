

<?php
include('login.php');

indexPage();



function mainPage() {
    echo <<< END
    <html>
        <head>
            <title>HW 4</title>
        </head>
        <body>
            Welcome to the site!<br><br>
            <form method='post' action='index.php' enctype='multipart/form-data'>
            	Please enter a string:
				<input type="text" name="enteredString">
				<br>
                Then, please upload a .txt File:
                <input type='file' name='fileUpload' id='fileUpload'>
                <input type='submit' name="submit" value='Upload'>
            </form>
        </body>
    </html>
END;

    if(isset($_POST["submit"])) {
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


function saveStringToDB ($string) {
    #TODO write string to database.
}

function saveTxtFileToDB ($file) {
    #TODO save file to database
}

function indexPage() {
    echo <<< END
    <html>
        <head>
            <title>This is HW5...</title>
        </head>
        <body>
            Welcome to the site!<br><br>
            <form method='post' action='index.php' enctype='multipart/form-data'>
            	Please enter a string:
				<input type="text" name="enteredString">
				<br>
                Then, please upload a .txt File:
                <input type='file' name='fileUpload' id='fileUpload'>
                <input type='submit' name="submit" value='Upload'>
            </form>
        </body>
    </html>
END;


}

