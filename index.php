<?php
  include('includes/init.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/main.css" rel="stylesheet" />
  <link href="styles/footer.css" rel="stylesheet" />

  <title>Uploadr</title>

  <div id="homelogo">
    <img src="images/uploadr-logo.png">
  </div>
</head>
<body>

  <div id="login-wrapper">
    <div id="login-interface">
      <p>Log In For Full Functionality</p>
      <form id="form_login" action="index.php" method="post">
          <input type="text" name="email" placeholder="EMAIL" required></input>
          <input type="password" name="password" placeholder="PASSWORD" required></input>
          <br>
          <button name="login" type="submit">Log In</button>
      </form>
      <div id="message-box">
        <?php
          display_messages();     //DISPLAY MESSAGES FOR USER
        ?>
      </div>
    </div>
    <h1 id="or">OR</h1>
    <div id="gallery-interface">
      <button id="gallerybutton" onclick="window.location.href='/gallery.php'">View The Gallery</button>
    </div>
  </div>


<section class="footer">
  <div id="footer">
    <?php include('includes/footer.php'); ?>
  </div>
</section>

</body>
</html>
