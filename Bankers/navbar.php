<?php
    session_start();
?>

<div class="navbar">
<ul>
    <li><a href="index.php" class="button">Home</a></li>

    <?php
        if(isset($_SESSION[userId])){
            echo "<li><a href='accountDetails.php' class=button>Account Details</a></li>";
            echo "<li><a href='transactions.php' class=button>Transactions</a></li>";
            echo "<li><a href='transfers.php' class=button>Transfers</a></li>";
            echo "<li><a href='standingOrders.php' class=button>Standing Order</a></li>";
        } else{
            echo "<li><a href='login.php' class=button>Login</a></li>";
            echo "<li><a href='signup.php' class=button>Sign Up</a></li>";
        }
    ?>
    <li><a href="help.php" class="button">Help</a></li>

</ul>
</div>
<br>
<br>
<br>
<br>
