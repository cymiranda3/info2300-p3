<!DOCTYPE html>
<link href="styles/header.css" rel="stylesheet" />
<?php
  include('includes/init.php');
?>

<header>
  <nav id="menu">
    <div id="header-wrapper">
      <div id="logo">
        <a href="gallery.php"><img src="images/uploadr-logo.png"></a>
      </div>
      <div id="navitem">
        <a href="gallery.php">GALLERY</a>
      </div>
      <div id="navitem">
        <a href="upload.php">UPLOAD</a>
      </div>
      <div id="navitem">
        <a href="singletag.php">ALL TAGS</a>
      </div>
      <div id="navitem">
        <?php
          if (checkstatus()) {
            echo "<a href='logout.php'>LOGOUT</a>";
          } else {
            echo "<a href='index.php'>LOGIN</a>";
          }
        ?>
      </div>
    </div>
  </nav>
</header>
