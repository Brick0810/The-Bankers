<?php
include "header.html";
include "include/functions.php";
include "navbar.php";

?>
<div class="signup">
<form action="include/login-include.php" method="post">
    <ul>
        <li><p>Username/Email</p></li>
        <li><input type="text" name="name" placeholder="Username/Email..."><li>
        <li><p>Password</p></li>
        <li><input type="password" name="password" placeholder="Password..."><li>
        <li><button type="submit" name="submit">Login In</button><li>
</ul>

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
</div>



<?php
include "footer.html";
?>
