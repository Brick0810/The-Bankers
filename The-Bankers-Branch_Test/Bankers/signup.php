<?php
include "header.html";
include "include/functions.php";
include "navbar.php";
?>

<body id="signup">
    <div class="signup">
        <h1>Sign Up</h1>
        <form action="include/signup-include.php" method="post">
            <div class="text">
                <li><p>First Name:</p></li>
                <input type="text" name="firstName">
                <li><p>Surname:</p></li>
                <input type="text" name="surname">
                <li><p>Email:</p></li>
                <input type="text" name="email">
                <li><p>Username:</p></li>
                <input type="text" name="userName">
                <li><p>Password:</p></li>
                <input type="password" name="password">
                <li><p>Re-Enter Password:</p></li>
                <input type="password" name="passwordRepeat">
                <li><button type="submit" name="submit">Sign Up</button></li>
            </div>
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
        </form>
    </div>
</body>

<?php
    include "footer.html";
?>

