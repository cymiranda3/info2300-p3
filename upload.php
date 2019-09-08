<!--Citation: I referenced the Lab 07 Solution for the upload functionality.
I did not copy-paste anything, I simply referenced. -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/upload.css" rel="stylesheet" />

  <title>Gallery</title>
  <?php include('includes/header.php'); ?>
</head>

<?php
  const maxSize = 1000000;

  if(isset($_POST["upload_file"]) and checkstatus()) {
    $file = $_FILES["file_to_upload"];

    $filepath = basename($file["name"]);
    $extension = strtolower(pathinfo("uploads/".$filepath, PATHINFO_EXTENSION));
    $size = $_FILES['file_to_upload']['size'];
    $name = explode(".", $filepath)[0];
    if($file['error'] == 0) {
      $db = new PDO('sqlite:proj3.sqlite');
      $clientsession = $_COOKIE['session'];
      $params = array(
        ':clientsession' => $clientsession
      );
      // FIND ID BASED ON SESSION
      $sql = "SELECT id FROM users WHERE session = :clientsession;";
      $uploader = exec_sql_query($db, $sql, $params)->fetchAll();

      //INSERT FILE INFORMATION INTO PHOTO_DATABASE TABLE
      $sql = 'INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ("photo_database", :name, :extension, :size, :uploader);';
      $params = array(
        ':name' => $name,
        ':extension' => $extension,
        ':size' => $size,
        ':uploader' => $uploader[0]['id']
      );
      $entry = exec_sql_query($db, $sql, $params);

      $id = $db->lastInsertId("file_id");
      //MOVE THE FILE TO THE APPROPRIATE FOLDER
      move_uploaded_file($file['tmp_name'], "uploads/photo_database/".$name."."."$extension");
      echo "<h2>File Uploaded Successfully!</h2>";

      // ADD RETURN TO GALLERY BUTTON
      button_return_to_gallery();
    }
  } else if (!checkstatus()) {      //NOTIFY USER THAT HE/SHE MUST LOGIN
    echo "<h3>Login Required to Upload Files!</h3>";
    echo "<a href='gallery.php'><h2>Return to Gallery<h2></a>";
  }

?>

<body>
  <h1> Upload New File: Must be smaller than 1 MB </h1>
  </form><form id="upload" action="upload.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="maxSize" value="<?php echo maxSize; ?>"</input>
        <input type="file" name="file_to_upload" required></input>
        <button name="upload_file" type="submit">Upload File</button>
    </ul>
  </form>
</body>

<section class="footer">
  <div id="footer">
    <?php include('includes/footer.php'); ?>
  </div>
</section>
</html>
