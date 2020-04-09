
  <?php include 'jquery.html';?>
  <?php include 'mysql_connect.php';?>
   

  <?php
    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    session_start();
    $stmt = $conn->prepare("insert into post (creator, title, content) values ( ?, ?, ?)");

    $stmt->bind_param("iss", 
      $creator,
      $title,
      $content
    );

    $creator =  $_SESSION['id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);

    $success = $stmt->execute();
    
    $stmt = $conn->prepare("select id, username from user");
      $stmt->execute();
      $result = $stmt->get_result();
      $dictionary = array();
      while($row = $result->fetch_assoc()) {
        $dictionary[$row['id']]=$row['username'];
      }
      //How to sanitize this 
      print('<p>');
          print('<b>Title: '.$title.'</b><br />');
          print('By: '.$dictionary[$creator].'<br /> ');
          print($content);
          print('</p>');
    
  ?>
