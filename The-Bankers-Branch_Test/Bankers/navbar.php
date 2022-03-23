<?php
    session_start();
?>

<div class="navbar">
<ul>
    <h1> The Bankers</h1>

    <?php
        if(isset($_SESSION[userName])){
            echo "<li><a href='accountDetails.php' class=button><img src='images/settings.png' alt='square' width='75' height='75' /></a></li>";
            echo "<li><a href='accounts.php' class=button>Accounts</a></li>";
            echo "<li><a href='help.php' class=button>Help</a></li>";
        } else{
            echo "<li><a href='login.php' class=button>Login</a></li>";
            echo "<li><a href='signup.php' class=button>Sign Up</a></li>";
            echo "<li><a href='help.php' class=button>Help</a></li>";
        }
    ?>
    <li><a href="index.php" class="button">Home</a></li>

</ul>
</div>

<!-- The sidebar -->
<div class="sidebar">
  <a href='transfers.php' class=button>Transfers</a>
  <a href='sendMoney.php' class=button>Send Money</a>
  <a href='#legal' class=button>Legal</a>
  <a href='include/logout-include.php' class=button>Logout</a>
</div>
<br>
<br>
<br>
<br>
