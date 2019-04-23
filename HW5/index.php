<?php
    require "header.php";
    require "footer.php";

    printIndexHTML1();

    if (isset($_SESSION['userId'])) {
        echo '<p class = "login-status">You are logged in!</p>';
    }
    else {
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