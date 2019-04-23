<?php
    require "header.php";
    require "footer.php";

    printIndexHTML1();

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
    else {
        if(isset($_GET["error"])) {
            //TODO
        }
        echo '<p class = "login-status">You are logged out!</p>';
    }

    printIndexHTML2();

    function printIndexHTML1()
    {
echo <<< END
        
<main>
    <div class="wrapper-main">
        <section class="section-default">
                        

END;
    }

    function printIndexHTML2()
    {
echo <<< END

      </section>
    </div>
</main>
END;
    }

    function saveStringToDB ($string) {
        #TODO write string to database.
    }

    function saveTxtFileToDB ($file) {
        #TODO save file to database
    }