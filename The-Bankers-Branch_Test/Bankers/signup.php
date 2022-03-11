<?php
include "header.html";
include "include/functions.php";
include "navbar.php";
?>

<div class="signup">
<form action="include/signup-include.php" method="post">
<ul>
    <li><p>First Name:</p></li>
    <li><input type="text" name="firstName" placeholder="First Name..."></li>
    <li><p>Surname:</p></li>
    <li><input type="text" name="surname" placeholder="Surname..."></li>
    <li><p>Email:</p></li>
    <li><input type="text" name="email" placeholder="Email..."></li>
    <li><p>Username:</p></li>
    <li><input type="text" name="userName" placeholder="Username..."></li>
    <li><p>Password:</p></li>
    <li><input type="password" name="password" placeholder="Password..."></li>
    <li><p>Re-Enter Password:</p></li>
    <li><input type="password" name="passwordRepeat" placeholder="Repeat Password..."></li>
    <li><button type="submit" name="submit">Sign Up</button></li>
</ul>
</form>

    <?php
        if(isset($_GET['error'])){ // checks against the URL to see if the text error exists in the URL
            if($_GET["error"] == "emptyInput"){
                echo "<p>Please fill in all the boxes!</p>";
            }
            else if ($_GET["error"] == "invalidId"){
                echo "<p>Choose a proper username ID!</p>";
            }
            else if ($_GET["error"] == "invalidPasswordMatch"){
                echo "<p>Passwords don't match!</p>";
            }
            else if ($_GET["error"] == "invalidEmail"){
                echo "<p>Choose a proper email!</p>";
            }
            else if ($_GET["error"] == "userIdExists"){
                echo "<p>User ID already exists, please choose another one!</p>";
            }
            else if ($_GET["stmtFailed"] == "stmtFailed"){
                echo "<p>Something went wrong, we are sorry. Please try again!</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>Success, you have signed up!</p>";
            }
        }
        ?>
</div>
</section>

<?php
    include "footer.html";
?>

