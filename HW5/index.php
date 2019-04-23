<?php
    require "header.php";
    require "footer.php";

    printIndex();

    if (isset($_SESSION['userId'])) {
        echo '<p class = "login-status">You are logged in!</p>';
    }
    else {
        echo '<p class = "login-status">You are logged out!</p>';
    }

    printIndex2();

    function printIndex()
    {
        echo <<< END
        
        
        <main>
            <div class="wrapper-main">
                <section class="section-default">
                

END;
    }

    function printIndex2()
    {
        echo <<< END
              </section>
                </div>
            </main>
END;
    }