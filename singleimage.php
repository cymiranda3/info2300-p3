<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/header.css" rel="stylesheet" />
  <link href="styles/singleimage.css" rel="stylesheet" />

  <title>Single Image View</title>
  <?php include('includes/header.php'); ?>
</head>

<body>

  <?php
    $file = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
    $filename_exploded = explode(".", $file);

    $db = new PDO('sqlite:proj3.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // GET SINGLE FILE INFORMATION FROM DATABASE
    $sql = "SELECT * FROM photo_database WHERE file_name = :filename_exploded;";
    $params = array(
      ':filename_exploded' => $filename_exploded[0]
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();

    //GET SESSION OF UPLOADER
    $sql = "SELECT session FROM users WHERE id = :uploader;";
    $params = array(
      ':uploader' => $records[0]['uploader']
    );
    $uploader = exec_sql_query($db, $sql, $params)->fetchAll();

  ?>
  <section class="singleimage">
    <div id="gallery-wrapper">
      <div id="imageSection">
        <!-- DISPLAY THE FILE PREVIEW -->
        <?php echo "<img src='uploads/".$records[0]['folder']."/".$records[0]['file_name'].".".$records[0]['file_extension']."'>"; ?>
      </div>
      <div id="descriptionSection">
        <h1>File Details:
          <?php
          if (!checkstatus()) {
            echo "<p class='message'>If you uploaded this file, please login to delete tags or the file.</p>";
          }
        ?></h1>
        <h4>

        File Name: <?php echo $filename_exploded[0]."</h4>"; ?>       <!-- DISPLAY FILENAME -->
        <h4>File Type: <?php echo $filename_exploded[1]."</h4>"; ?>       <!-- DISPLAY FILETYPE -->
        <h4>File Size:                                                    <!-- DISPLAY FILESIZE -->
          <?php
          foreach ($records as $record) {
            echo $record['file_size']." Bytes</h4>";
            $fileid = $record['file_id'];
          }
          ?>
        <h4>File Tags:                                                    <!-- DISPLAY FILETAGS -->
          <?php
            $db = new PDO('sqlite:proj3.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT tags.tag_name FROM tags JOIN photo_tags ON tags.tag_id = photo_tags.tag WHERE photo_tags.photo = (SELECT photo_database.file_id FROM photo_database WHERE photo_database.file_name = :filename_exploded);";
            $params = array(
              ':filename_exploded' => $filename_exploded[0]
            );
            $tags = exec_sql_query($db, $sql, $params);

            foreach ($tags as $tag) {
              if (checkstatus() and ($uploader[0]['session'] == $_COOKIE['session'])) {
                echo "<form method='get' action='singletag.php'><div class='addwrapper'><div class='button1'><button type='submit' name='tag' value='".$tag['tag_name']."' class='linkbutton'>".$tag['tag_name']."</button></div></form><form method='get' action='deletetag.php'><input type='hidden' name='photoid' value='".$fileid."'><div class='button2'><button type='submit' class='delete' name='tagtodelete' value='".$tag['tag_name']."' class='linkbutton'>&#x2715;</button></div></form><br>";
              } else {
                echo "<form method='get' action='singletag.php'><div class='button1'><button type='submit' name='tag' value='".$tag['tag_name']."' class='linkbutton'>".$tag['tag_name']."</button></div></form><br><br>";
              }
            }
            echo "</h4>";

          ?>
        <!-- ADDING TAGS -->
        <?php
          $sql = "SELECT session FROM users WHERE id = :uploader;";
          $params = array(
            ':uploader' => $record['uploader']
          );
          $uploader = exec_sql_query($db, $sql, $params)->fetchAll();

          // DISPLAY TAG INFORMATION
            echo "<h4 id='addtag'>Add Tag:</h4>";
            echo "<form action='addtag.php' method='get'>";
              echo "<input type='hidden' name='photoid' value='".$fileid."'>";
              echo "<input type='text' name='tag'><br>";
              echo "<button type='submit' id='tagaddbutton' name='addtag' class='linkbutton'>Add Tag</button>";
            echo "</form>";

        ?>

        <!-- DELETING PHOTO -->
        <h4>
        <?php
          if (checkstatus() and ($uploader[0]['session'] == $_COOKIE['session'])) {
            echo "<form action='deletefile.php' method='get'>";
              echo "<input type='hidden' name='photoid' value='".$fileid."'>";
              echo "<button type='submit' id='deletebutton' name='deletefile' class='linkbutton'>Delete File</button>";
            echo "</form>";

          }
          echo "</h4>";

        button_return_to_gallery();
        ?>

      </div>
    </div>
  </section>

  <section class="footer">
    <div id="footer">
      <?php include('includes/footer.php'); ?>
    </div>
  </section>

  </body>
</html>
