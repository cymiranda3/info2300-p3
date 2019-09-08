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
  // Check for login and that GET request is set
  if(isset($_GET['photoid']) and checkstatus()) {
    $photoid = filter_input(INPUT_GET, 'photoid', FILTER_SANITIZE_STRING);
    $sql = "SELECT folder, file_name, file_extension FROM photo_database WHERE file_id = :photoid;";
    $params = array(
      ':photoid' => $photoid
    );
    $filepatharray = exec_sql_query($db, $sql, $params)->fetchAll();
    // DELETE THE FILE FIRST
    unlink('uploads/'.$filepatharray[0]['folder']."/".$filepatharray[0]['file_name'].'.'.$filepatharray[0]['file_extension']);

    // DELETE FROM PHOTO_DATATBASE TABLE
    $sql = "DELETE FROM photo_database WHERE file_id = :photoid;";
    exec_sql_query($db, $sql, $params);

    // DELETE FROM PHOTO_TAGS TABLE
    $sql = "DELETE FROM photo_tags WHERE photo = :photoid;";
    exec_sql_query($db, $sql, $params);

    echo "<h1>File Deleted Succesfully</h1>";
  } else {
    echo "<h1>Unable to Delete Tag.</h1>";
  }
  button_return_to_gallery();     //INSERT RETURN TO GALLERY BUTTON

  ?>

  <section class="footer">
    <div id="footer">
      <?php include('includes/footer.php'); ?>
    </div>
  </section>
</body>
</html>
