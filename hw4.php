<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$query = "CREATE TABLE IF NOT EXISTS files (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Name VARCHAR(32) NOT NULL,Content LONGTEXT)";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);

    echo <<< END
    <html>
        <head>
            <title>HW 4</title>
        </head>
        <body>
            Welcome to the site!<br><br>
            <form method='post' action='hw4.php' enctype='multipart/form-data'>
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
        $query = "INSERT INTO files VALUES(NULL,'$userString','$theFile')";
        $result = $conn->query($query);
    }
    else {
        echo "This file is not a txt file. Please try uploading again...";
    }
}

$sql = "SELECT Name, Content FROM files";
$resultB = mysqli_query($conn,$sql);

print "<table border=1>\n"; 
while ($row = mysqli_fetch_array($resultB,MYSQLI_ASSOC)){ 
$files_field= $row['Name'];
$descriptionvalue= $row['Content'];
print "<tr>\n"; 
print "\t<td>\n"; 
echo "<font face=arial size=4/>$files_field</font>";
print "</td>\n";
print "\t<td>\n"; 
echo "<div align=center>$descriptionvalue</div>";
print "</td>\n";
print "</tr>\n"; 
} 
print "</table>\n"; 




mysqli_close();




?>