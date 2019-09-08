<?php
  include("includes/init.php");
  $activeuser = check();
  global $loggedin;
  $loggedin = false;
?>
<html>
<link href="styles/main.css" rel="stylesheet" />
  <title>Logout</title>
</head>
<body id="logoutbody">
<?php
  $db = new PDO('sqlite:proj3.sqlite');
  if ($activeuser) {
    //DELETE SESSION FROM ACTIVE USER
    $sql = 'UPDATE users SET session = NULL WHERE email = :activeuser;';
    $params = array(
      ':activeuser' => $activeuser
    );
    exec_sql_query($db, $sql, $params);

    //DELETE COOKIE FROM ACTIVE USER
    setcookie("session", "", time()-3000);
    $loggedin = false;
    $activeuser = NULL;
    echo "<h1>Successfully Logged Out!</h1>";
    button_return_to_gallery();
  } else {
    echo "<h1>Already Logged Out</h1>";
    button_return_to_gallery();
  }

  //Check logged in user
  function check() {
    if (isset($_COOKIE["session"])) {
      $session = $_COOKIE["session"];
      $db = new PDO('sqlite:proj3.sqlite');
      $sql = 'SELECT * FROM users WHERE session = :session;';
      $params = array(
        ':session' => $session
      );
      $records = exec_sql_query($db, $sql, $params)->fetchAll();
      if($records) {
        $account = $records[0];
        return $account["email"];
      }

    }
    return NULL;
  }
?>
</body>
</html>
