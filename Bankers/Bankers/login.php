<?php
include "header.html";
include "include/functions.php";
include "navbar.php";

?>

<section class="style.css">
<h2>Login</h2>
<form action="include/login-include.php" method="post">
    <input type="text" name="name" placeholder="Username/Email...">
    <input type="password" name="password" placeholder="Password...">
    <button type="submit" name="submit">Login In</button>

</form>

<?php
if(isset($_GET["error"])) // checks against the URL to see if the text error exists in the URL
    if($_GET["error"] == "emptyInput"){
        echo "<p>Fill in all fields!</p>";
    }
    else if ($_GET["error"] == "loginIncorrect"){
        echo "<p>Login Incorrect, please try again!</p>";
    }
?>
</section>



<?php
include "footer.html";
?>
