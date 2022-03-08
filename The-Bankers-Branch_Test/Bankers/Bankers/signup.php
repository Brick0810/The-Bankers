<?php
include "header.html";
include "include/functions.php";
include "navbar.php";
?>


<section class="style.css">
<h2>Sign Up</h2>
<form action="include/signup-include.php" method="post">
    <input type="text" name="firstName" placeholder="First Name...">
    <input type="text" name="surname" placeholder="Surname...">
    <input type="text" name="email" placeholder="Email...">
    <input type="text" name="userName" placeholder="Username...">
    <input type="password" name="password" placeholder="Password...">
    <input type="password" name="passwordRepeat" placeholder="Repeat Password...">
    <button type="submit" name="submit">Sign Up</button>
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

</section>

<?php
    include "footer.html";
?>

