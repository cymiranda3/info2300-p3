<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/gallery.css" rel="stylesheet" />

  <title>Gallery</title>
  <?php include('includes/header.php'); ?>
</head>

<body>
  <section class="gallery">

    <?php
      display_gallery(); //DISPLAY THE GALLERY
    ?>
  </section>

  <section class="footer">
    <div id="footer">
      <?php include('includes/footer.php'); ?>
    </div>
  </section>
</body>
</html>
