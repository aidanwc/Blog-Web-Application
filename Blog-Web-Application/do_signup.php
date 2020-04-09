<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>

  <?php
    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp

    $stmt = $conn->prepare("insert into user (username, password) values (?, ?)");

    $stmt->bind_param("ss", 
      $name,
      $password
    );

    $name = strip_tags($_POST['name']);

    // Hash the password so we don't store
    // password in plain text
    $password = password_hash(
      $_POST['password'],PASSWORD_DEFAULT);

    $success = $stmt->execute();
  ?>
  <p>
    <?php
      if (!$success) {
        print('Username already taken: Please try again. ');
      }
      else {
        print('Signup successful');
      }
    ?>
  </p>
</body>