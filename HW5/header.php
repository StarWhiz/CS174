<?php
    session_start();

// Start Page Is HERE
// Credits to: https://www.youtube.com/watch?v=LC9GaXkdxF8 for the tutorial 1:39:27
// Written By: Tai Dao

    printHeader();

    if (isset($_SESSION['userId'])) {
        echo '<form action="includes/logout.inc.php" method="post">
            <button type="submit" name="logout-submit">Logout</button>
            </form>';
    }
    else {
        echo '                   
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="mailuid" placeholder="Username/E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit" name="login-submit">Login</button>
            </form>
            <a href="signup.php">Signup</a>';
    }

    printHeader2();

    function printHeader()
    {
        echo <<< END
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="description" content = "This is my homework 5 meta description..."
            <meta name=viewport content="width=device-width, initial-scale=1">
            <title>Homework 5 Authentication</title>
        </head>
        <body>
        
            <header>
                <a href="#">
                    <img src="img/blackholechan.jpg" alt="logo" width="300" height="423">
                </a>
                
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
                
                <div class="header-login">
END;
    }

    function printHeader2() {
        echo <<< END


                </div>
            </header>
END;
    }

