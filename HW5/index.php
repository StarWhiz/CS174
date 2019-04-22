<?php
    require "header.php";
    require "footer.php";

    printIndex();

    function printIndex()
    {
        echo <<< END
        
        
        <main>
            <p>You are logged out!</p>
            <p>You are logged in!</p>
        </main>


END;

    }