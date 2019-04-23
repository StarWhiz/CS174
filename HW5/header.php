<?php
    // Start Page Is HERE
    // Credits to: https://www.youtube.com/watch?v=LC9GaXkdxF8 for the tutorial 1:39:27
    // Written By: Tai Dao
    session_start();
    printHTML1();

    if (isset($_SESSION['userId'])) {
        echo '<form action="includes/logout.inc.php" method="post">
            <button type="submit" name="logout-submit">Logout</button>
            </form>';
    }
    else {
        echo '<form action="includes/login.inc.php" method="post">
                <input type="text" name="mailuid" placeholder="Username/E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit" name="login-submit">Login</button>
            </form>
            <a href="signup.php" class="header-signup">Signup</a>';
    }

    printHTML2();

    function printHTML1()
    {
        echo <<< END
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <meta charset="utf-8">
                <meta name="description" content = "This is my homework 5 meta description..."
                <meta name=viewport content="width=device-width, initial-scale=1">
                <title>Homework 5 Authentication</title>
            </head>
            <body>
                <header>
                    <nav class="nav-header-main">
                            <a class="header-logo" href="index.php">
                              <img src="img/logo.png" alt="mmtuts logo">
                            </a>
                          </nav>
                          <div class="header-login">
END;
    }

    /*           <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
    */
    function printHTML2() {
        echo <<< END
                </div>
            </header>
        </html>
END;
    }

