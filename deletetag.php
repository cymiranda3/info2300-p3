<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/main.css" rel="stylesheet" />
  <link href="styles/singleimage.css" rel="stylesheet" />

  <title>Delete Tag From Image</title>
  <?php include('includes/header.php'); ?>
</head>

<body>
  <?php
  $db = new PDO('sqlite:proj3.sqlite');
  if(isset($_GET['tagtodelete']) and checkstatus()) {
    // FIGURE OUT THE TAGID OF THE TAG THAT THE USER WANTS TO DELETE
    $tagtodelete = filter_input(INPUT_GET, 'tagtodelete', FILTER_SANITIZE_STRING);
    $sql = "SELECT tag_id FROM tags WHERE tag_name = :tagtodelete;";
    $params = array(
      ':tagtodelete' => $tagtodelete
    );
    $tagid = exec_sql_query($db, $sql, $params)->fetchAll()[0]['tag_id'];

    //DELETE THE TAG
    $photoid = filter_input(INPUT_GET, 'photoid', FILTER_SANITIZE_STRING);
    $sql = "DELETE FROM photo_tags WHERE tag = ".$tagid." and photo = :photoid;";
    $params = array(
      ':photoid' => $photoid
    );
    exec_sql_query($db, $sql, $params);

    echo "<h1>Tag Deleted Succesfully</h1>";
  } else {
    echo "<h1>Unable to Delete Tag.</h1>";
  }

  button_return_to_picture($photoid);     //ADD BUTTON TO RETURN TO PHOTO
?>

<section class="footer">
  <div id="footer">
    <?php include('includes/footer.php'); ?>
  </div>
</section>

</body>
</html>
