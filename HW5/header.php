<?php


// Start Page Is HERE
// Credits to: https://www.youtube.com/watch?v=LC9GaXkdxF8 for the tutorial
// Written By: Tai Dao

printHeader();

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
            <nav>
                <a href="#">
                    <img src="img/blackholechan.jpg" alt="logo" width="300" height="423">
                </a>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
                <div>
					<form action="includes/login.inc.php" method="post">
					    <input type="text" name="mailuid" placeholder="Username/E-mail">
					    <input type="password" name="pwd" placeholder="Password">
					    <button type=""submit" name="login-submit">Login</button>
					</form>
					<a href="signup.php">Signup</a>
					<form action="includes/logout.inc.php" method="post">
					    <button type=""submit" name="logout-submit">Logout</button>
					</form>	
				</div>
            </nav>
        </header>


END;
}