<?php

// Can only access this page if they press the login button.
if (isset($_POST['login-submit'])) {
    require 'database_inc.php';
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    echo $mailuid;
    echo $password;

    if (empty($mailuid) || empty ($password)) {
        header("Location: ./index.php?error=emptyfields");
        exit();
    }
    else {
        $sql = "SELECT * FROM users WHERE uidUSERS=?;";   # OR emailUsers=?
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['pwdUsers']);

                // Password doesn't match password in db
                if ($pwdCheck == false) {
                    header("Location: ./index.php?error=wrongpwd");
                    exit();
                }

                // Password matches password in db
                else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];


                    header("Location: ./index.php?login=success");
                    exit();
                }

                // Other cases
                else {
                    header("Location: ./index.php?error=wronguidpwd");
                    exit();
                }
            }
            // Empty User
            else {
                header("Location: ./index.php?error=nouser");
                exit();
            }

        }
    }
}
else {
    header("Location: ./index.php");
    exit();
}