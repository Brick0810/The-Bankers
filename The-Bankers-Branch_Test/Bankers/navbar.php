<?php
    session_start();
?>

<div class="navbar">
<ul>
    <h1> The Bankers</h1>
    <li><a href="help.php" class="button">Help</a></li>

    <?php
        if(isset($_SESSION[userId])){
            echo "<li><a href='accountsView.html' class=button>Accounts</a></li>";
            echo "<li><a href='transactionsView.html' class=button>Transactions</a></li>";
            echo "<li><a href='transfersView.html' class=button>Transfers</a></li>";
            echo "<li><a href='standingOrdersView.html' class=button>Standing Order</a></li>";
            echo "<li><a href='include/logout-include.php' class=button>Logout</a></li>";
        } else{
            echo "<li><a href='login.php' class=button>Login</a></li>";
            echo "<li><a href='signup.php' class=button>Sign Up</a></li>";
        }
    ?>
    <li><a href="index.php" class="button">Home</a></li>

</ul>
</div>
<br>
<br>
<br>
<br>
