<?php

global $activeuser;
$messages = array();
$loggedin = false;

// show database errors during development.
function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' . $exception->getMessage()) . '</strong></p>';
}

// execute an SQL query and return the results.
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
}

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        handle_db_error($exception);
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

//DISPLAY MESSAGES TO USER
function display_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<h5>".$message."<h5>";
  }
}

//DISPLAY GALLERY FOR USER
function display_gallery() {
    $db = new PDO('sqlite:proj3.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function sql_func($db, $sql, $params) {
          $query = $db->prepare($sql);
            if ($query and $query->execute($params)) {
              $records = $query->fetchAll();
              return $records;
            }
            return NULL;
        }

    $sql = "SELECT * FROM photo_database;";
    $params = array ();
    $records = sql_func($db, $sql, $params);

    foreach ($records as $record) {
      echo "<div id='individual_photo'>"."<a href='singleimage.php?filename=".$record['file_name'].".".$record['file_extension']."'>"."<img height='200px' src='uploads/".$record['folder']."/".$record['file_name'].".".$record['file_extension']."'></a></form><form method='get' action='singleimage.php'><button type='submit' name='filename' value='".$record['file_name'].".".$record['file_extension']."' class='linkbutton'>".$record['file_name'].".".$record['file_extension']."</button></form></div>";
    }
}

//CHECK LOGIN STATUS
function checkstatus() {
  global $db;
  global $loggedin;

  if(isset($_COOKIE['session'])) {
    $session = $_COOKIE['session'];
    $params = array();
    $sql = 'SELECT * FROM users WHERE session = "'.$session.'";';
    $usersloggedin = exec_sql_query($db, $sql, $params);
    if($usersloggedin) {
      $loggedin = true;
    } else {
      $loggedin = false;
    }
  } else {
    $loggedin = false;
  }
  return $loggedin;
}

//GENERATE BUTTON TO RETURN TO PHOTO
function button_return_to_picture($id) {
  $db = new PDO('sqlite:proj3.sqlite');
  $params = array();
  $sql = "SELECT file_name, file_extension FROM photo_database WHERE file_id = ".$id.";";
  $filepatharray = exec_sql_query($db, $sql, $params)->fetchAll();
  echo "</form><form method='get' action='singleimage.php'><button class='backbutton' type='submit' name='filename' value='".$filepatharray[0]['file_name'].".".$filepatharray[0]['file_extension']."'>Return to Photo</button></form>";
}

//GENERATE BUTTON TO RETURN TO GALLERY
function button_return_to_gallery() {
  echo "</form><form action='gallery.php'><button class='backbutton' type='submit' name='filename'>Return to Gallery</button></form>";
}
//LOG IN USER
function login ($email, $password) {
  global $messages;
  if ($email && $password) {

    $db = new PDO('sqlite:proj3.sqlite');
    $sql = 'SELECT * FROM users WHERE email = "'.$email.'";';
    $params = array();
    $usersfound = exec_sql_query($db, $sql, $params)->fetchAll();

    if ($usersfound) {
      $user_tologin = $usersfound[0];
      if (password_verify($password, $user_tologin['password'])) {
        header("Location: gallery.php");
        $session = uniqid();

        $sql = 'UPDATE users SET session = :session WHERE email = :email;';
        $params = array(
          ':session' => $session,
          ':email' => $email
        );
        $finishedlogin = exec_sql_query($db, $sql, $params);
        if ($finishedlogin) {
          setcookie("session", $session, time()+3000);
          return $email;
        }
      } else {
        array_push($messages, "Username and Password do not match");
      }
    } else {
      array_push($messages, "Username and Password do not match");
    }
  }
  return NULL;
}

//BEGIN LOGIN PROCESS
if (isset($_POST['login'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
  $email = trim($email);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $activeuser = login($email, $password);
}

$db = open_or_init_sqlite_db('proj3.sqlite', "init/init.sql");
?>
