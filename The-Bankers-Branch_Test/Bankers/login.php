<?php
include "header.html";
include "include/functions.php";
include "navbar.php";

?>
<body id="signup">
    <div class="signup">
        <h1>Login</h1>
            <form action="include/login-include.php" method="post">
                <div class="text">
                    <li><p>Username/Email:</p></li>
                    <input type="text" name="name">
                    <li><p>Password:</p></li>
                    <input type="password" name="password">
                    <li><button type="submit" name="submit">Login In</button><li>
                        <div class="signup_link">Not a member? <a href="signup.php">Signup</a></div>
                </div>

                <?php
                if(isset($_GET["error"])) // checks against the URL to see if the text error exists in the URL
                    if($_GET["error"] == "emptyInput"){
                        echo "<p>Fill in all fields!</p>";
                    }
                else if ($_GET["error"] == "loginIncorrect"){
                    echo "<p>Login Incorrect, please try again!</p>";
                }
                ?>
            </form>
        </div>
</body>



<?php
include "footer.html";
?>
