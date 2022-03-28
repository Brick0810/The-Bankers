<?php
include "header.html";
include "include/functions.php";
include "navbar.php";
?>

<body id="signup">
    <div class="signup">
        <h1>Send Email</h1>
          <form class="contact-form" action="https://formsubmit.co/U2066800@unimail.hud.ac.uk" method="post">
              <div class="text">
                  <input type="text" name="name" placeholder="Full Name..." required>
                  <input type="email" name="email" class="form-control" placeholder="Your e-mail..." required>
                  <input type="text" name="subject" placeholder="Subject..." required>
                  <textarea placeholder="What would you like help with?" class="messageBox" name="message" rows="10" required></textarea>
                  <input type="hidden" name="_template" value="box">
                  <input type="hidden" name="_captcha" value="false">
                  <input type="hidden" name="_next" value="https://selene.hud.ac.uk/u2066800/include/contactUs-include.php">
                  <button type="submit" name="submit">SEND MAIL</button>
            </div>
          </form>
    </div>
</body>
