<?php
require "header.php";


    printSignUpHTML1();

    if(isset($_GET["error"])) {
        if ($_GET["error"] == "emptyfields") {
            echo '<p class="signuperror">Fill in all fields!</p>';
        }
        else if ($_GET["error"] == "invaliduidmail") {
            echo '<p class="signuperror">Invalid username and email!</p>';
        }
        else if ($_GET["error"] == "invaliduid") {
            echo '<p class="signuperror">Invalid username!</p>';
        }
        else if ($_GET["error"] == "invalidmail") {
            echo '<p class="signuperror">Invalid email!</p>';
        }
        else if ($_GET["error"] == "passwordcheck") {
            echo '<p class="signuperror">Passwords do not match!</p>';
        }
        else if ($_GET["error"] == "usertaken") {
            echo '<p class="signuperror">Username is already taken!</p>';
        }
    }
    else if (isset($_GET["signup"])) {
        if ($_GET["signup"] == "success") {
            echo '<p class="signupsuccess">Signup is successful!</p>';
        }
    }


    printSignUpHTML2();




function printSignUpHTML1() {
    echo <<< END
<main>
    <div class="wrapper-main">
        <section class="section-default">

END;
}

function printSignUpHTML2() {
    echo <<< END
            <form class="form-signup" action="signup_inc.php" method="post">
                <h1>Registration Form</h1>
                <input type="text" name="uid" placeholder="Username">
                <input type="text" name="mail" placeholder="E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Repeat Password">
                <button type="submit" name="signup-submit">Sign Up</button>
            </form>
        </section>
    </div>
</main>
END;
}



require "footer.php";