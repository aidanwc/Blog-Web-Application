<?php
// https://www.w3schools.com/php/php_sessions.asp
// session_start must be run before any other output
session_start();
?>
<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>
  <?php include 'jquery.html';?>
  <p>
  <h1>Posts</h1>
  
  <section id="posts">
  <?php 
      //Create a dictionary of User id to username
      $stmt = $conn->prepare("select id, username from user");
      $stmt->execute();
      $result = $stmt->get_result();
      $dictionary = array();
      while($row = $result->fetch_assoc()) {
        $dictionary[$row['id']]=$row['username'];
      }
    
      //Print current posts 
     $stmt = $conn->prepare("select creator, title, content from post");
     $stmt->execute();
     $result = $stmt->get_result();
      if ($result->num_rows == 0) {
        print('<p id="noPost">No Posts Availible</p>');
      }else{
        while($row = $result->fetch_assoc()) {
          print('<p>');
          print('<b>Title: '.$row['title'].'</b><br />');
          print('By: '.$dictionary[$row['creator']].'<br /> ');
          print($row['content']);
          print('</p>');
        }
      }
      ?>
       </section>
  <section>
  <?php
 
    // check if $_SESSION['student_id'] is declared
    // if it is, then the user is logged in
   
    if (isset($_SESSION['id'])) {
      print('<h1>POST:</h1>');
      print('<b>Make a post as: '.$_SESSION['username'].'</b>');
      print('<form id="myform">');
      print('<p>Title <input type="text" name="title" id="title" /></p>');
      print('<p>Content </p>');
      print('<textarea name="content" rows="10" cols="30" id="content" /></textarea><br />');
      print('<input type="submit" value="Submit Post"/>');
      print('</form>');
    }
    else {
      print('<p><b>You need to login to make a post</></p>');
    }
  ?>
  </section>
  
  <script>
    function showPosts(data) {
      if($('#noPost').length){
      $('#noPost').remove();
      }
      $('#posts').append(data);
    }
    
    $('#myform').submit(function(event){
        if($.trim($('#title').val()) == ''||$.trim($('#content').val()) == ''){
            alert('Input can not be left blank');
            return;
        }
        event.preventDefault();
        $.ajax({
                method: "POST",
                url: "make_post.php",
                data: {title: $('#title').val(), 
                       content: $('#content').val()
                        }
               
                
                }).done(function(msg) {
                  $('#title').val('');
                  $('#content').val('');
                  showPosts(msg);
                });
     });

  </script>
</body>