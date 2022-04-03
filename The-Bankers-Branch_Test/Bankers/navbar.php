<?php
    session_start();
?>

<head>
    <title>Navbar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="navbar">
    <header>
        <img class="logo" src="images/logo.png" alt="logo">
        <nav>
            <ul class="navbar_class">
            <?php
            echo "<li><a href='index.php' class=button>Home</a></li>";
                if(isset($_SESSION[userName])) {
                    echo "<li><a href='accounts.php'' class=button>Accounts</a></li>";
                    echo "<li><a href='help.php' class=button>Help</a></li>";
                    echo "<li><a href='accountDetails.php' class=figure><img src='images/settings.png' alt='square' width='75' height='75' /></a></li>";
                } else{
                    echo "<li><a href='login.php' class=button>Login</a></li>";
                    echo "<li><a href='signup.php' class=button>Sign Up</a></li>";
                }
             ?>
            </ul>
        </nav>
    </header>
</body>

<body id="sidebar">
    <div class="sidebar">
        <ul>
            <li><a href='transfers.php' class=button>Transfers</a></li>
            <li><a href='sendMoney.php' class=button>Send Money</a></li>
            <li><a href='legal.php' class=button>Legal</a></li>
            <li><a href='help.php' class=button>Help</a></li>
            <li><a href='contactUs.php' class=button>Contact Us</a></li>
            <?php
            if(isset($_SESSION[userName])) {
                echo "<li><a href='include/logout-include.php' class=button>Logout</a></li>";
            }
            ?>
            <li><a></a></li>
        </ul>
    </div>
</body>