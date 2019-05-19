<?php
    // Written By: Tai Dao
    session_start();
    require_once "database_inc.php";

echo <<< END
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content = "This is my homework 5 meta description..."
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>174 Final Project</title>
        <link rel="stylesheet" type="text/css" href="style.php"/>
    </head>
    <body>

        <header>
            <nav class="nav-header-main">
                <a class="header-logo" href="index.php">
                    <img src="logo.png" alt="Tai Logo">
                </a>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </nav>
            <div class="header-login">
END;

    // Already Logged In
    if (isset($_SESSION['userId'])) {
        echo'
                <form action="logout_inc.php" method="post">
                    <button type="submit" name="logout-submit">Logout</button>
                </form>';
    }

    // Not Logged In
    else {
        echo'
                <form action="login_inc.php" method="post">
                    <input type="text" name="mailuid" placeholder="Username/E-mail">
                    <input type="password" name="pwd" placeholder="Password">
                    <button type="submit" name="login-submit">Login</button>
                </form>
                <a href="signup.php" class="header-signup">Signup</a>';
    }

echo <<< END
        </div>
    </header>
</html>
END;
