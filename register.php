

<?php

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];
    require_once 'dbconn.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) {
        echo "<p>Error: Could not connect to database.<br/>
        Please try again later.</p>";
          die($conn -> error);
      }
      $query="SELECT * FROM admin  WHERE  username='$username' ";

      $result = $conn->query($query);
 
      $rows = $result->num_rows;
      if($rows>0){
        $_SESSION['message']="Register Failed. This User Added Before!";
        header('location:log_admin.php');
      }
      elseif($rows==0){
        $query = "INSERT INTO admin (username, admin_password)  VALUES 
        ('$username','$password')" ;
    
        $result = $conn->query($query);
        if ($result) {
        header("Location: log_admin.php");    
    } 
        
        else {
            $_SESSION['message']="Register Failed.";
            header('location:log_admin.php');        }
           $conn -> close();
    }
?>