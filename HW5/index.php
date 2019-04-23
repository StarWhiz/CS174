<?php
    require "header.php";
    require "footer.php";

    if (isset($_SESSION['userId'])) {
        echo '<p class = "login-status">You are logged in!</p>';
    }
    else {
        echo '<p class = "login-status">You are logged out!</p>';
    }

    #printIndex();

    function printIndex()
    {
        echo <<< END
        
        
        <main>

        </main>


END;

    }