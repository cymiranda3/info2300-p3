<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/gallery.css" rel="stylesheet" />
  <link href="styles/singletag.css" rel="stylesheet" />

  <title>All Tags</title>
  <?php include('includes/header.php'); ?>
</head>

<body>
  <h2>Click a tag below to view tagged images!</h2>
    <?php
        //DISPLAY ALL DISTINCT TAGS, MAKING SURE TO ONLY DISPLAY TAGS WITH PHOTOS ATTACHED
        $sql = "SELECT DISTINCT tag_name FROM tags JOIN photo_tags ON tag_id = tag;";
        $params = array();
        $alltags = exec_sql_query($db, $sql, $params)->fetchAll();
        echo "<div id='tagwrapper'>";
        foreach ($alltags as $tag) {
          echo "<div id='tagelement'><form method='get' action='singletag.php'><button type='submit' name='tag' value='".$tag['tag_name']."' class='linkbutton'>".$tag['tag_name']."</button></form></div>";
        }
        echo "</div>";
      echo "</section>";
    ?>
    <section class="tagged_images">
    <?php
      $db = new PDO('sqlite:proj3.sqlite');
      if (isset($_GET['tag'])) {
        //GET TAG ID
        $tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT tag_id FROM tags WHERE tag_name = :tag;";
        $params = array(
          ':tag' => $tag
        );
        $tagid = exec_sql_query($db, $sql, $params)->fetchAll();

        // IF TAGID EXISTS, THEN PROCEED TO DISPLAY THE IMAGES ASSOCIATED; ELSE, DISPLAY MESSAGE TO USER
        if ($tagid != NULL) {
          $sql = "SELECT photo FROM photo_tags WHERE tag = :tag;";
          $params = array(
            ':tag' => $tagid[0]['tag_id']
          );
          $photos_from_tag = exec_sql_query($db, $sql, $params)->fetchAll();

          echo "<h3>Photos Tagged '".$tag."'<h3>";
          foreach ($photos_from_tag as $photo) {
            $sql = "SELECT folder, file_name, file_extension FROM photo_database WHERE file_id = :photo;";
            $params = array(
              ':photo' => $photo['photo']
            );
            $filepatharray = exec_sql_query($db, $sql, $params)->fetchAll();

            echo "<div id='individual_photo'>"."<a href='singleimage.php?filename=".$filepatharray[0]['file_name'].".".$filepatharray[0]['file_extension']."'>"."<img height='200px' src='uploads/".$filepatharray[0]['folder']."/".$filepatharray[0]['file_name'].".".$filepatharray[0]['file_extension']."'></a></form><form method='get' action='singleimage.php'><button type='submit' name='filename' value='".$filepatharray[0]['file_name'].".".$filepatharray[0]['file_extension']."' class='linkbutton'>".$filepatharray[0]['file_name'].".".$filepatharray[0]['file_extension']."</button></form></div>";
          }
        } else {
          echo "<h3>No Images Tagged '".$_GET['tag']."'.</h3>";
        }
      }
    ?>
  </section>

  <section class="footer">
    <div id="footer">
      <?php include('includes/footer.php'); ?>
    </div>
  </section>

  </body>
</html>
