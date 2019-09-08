<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/main.css" rel="stylesheet" />
  <link href="styles/singleimage.css" rel="stylesheet" />

  <title>Single Image View</title>
  <?php include('includes/header.php'); ?>
</head>

<body>
  <?php
  $db = new PDO('sqlite:proj3.sqlite');
    // Check for login and make sure GET request is set
    if(isset($_GET['tag'])) {
      $tagentry = strtoupper(filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING));   //Sanitize tag and convert tag to uppercase
      $params = array (
        ':tagentry' => $tagentry
      );
      //IF TAG DOES NOT EXIST YET, THEN ADD IT
      if (exec_sql_query($db, "SELECT * FROM tags WHERE tag_name = :tagentry", $params)->fetchAll() == NULL) {
        $sql = "INSERT INTO tags (tag_name) VALUES (:tagentry);";
        exec_sql_query($db, $sql, $params);
      }
      //IF IT EXISTED, OR NOW THAT IT DOES EXIST, FIND ITS TAGID
      $sql = "SELECT tag_id FROM tags WHERE tag_name = '".$tagentry."';";
      $params = array ();
      $tagid = (exec_sql_query($db, $sql, $params)->fetchAll())[0]['tag_id'];
      //ADD TAGID TO PHOTO
      $photoid = filter_input(INPUT_GET, 'photoid', FILTER_SANITIZE_STRING);
      $params = array (
        ':tagid' => $tagid,
        ':photoid' => $photoid
      );
      //ADD TO PHOTO_TAGS TABLE IF IT DOESNT EXIST YET (PREVENT DUPLICATES)
      if (exec_sql_query($db, "SELECT * FROM photo_tags WHERE tag = :tagid and photo = :photoid;", $params)->fetchAll() == NULL) {
        $sql = "INSERT INTO photo_tags (tag, photo) VALUES (:tagid, :photoid);";
        exec_sql_query($db, $sql, $params);
        echo "<h1>Tag Added Successfully!</h1>";
      } else {
        echo "<h1>Unable to add tag because it already has been applied to this file.</h1>";
      }
    }
    // Insert navigation button back to photo
    button_return_to_picture($photoid)
  ?>
