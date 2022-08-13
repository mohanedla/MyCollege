<?php

session_start();
require_once '../dbconn/dbconn.php';

if(isset($_POST['submit'])){


   $username = $_POST['username'];
   $password = $_POST['password'];
   $select ="SELECT * FROM student  WHERE   student_id='$username' and student_password='$password'";

   $result = $conn->query($select);
   $rows= $result->num_rows;
   if($rows > 0){

      $row = $result->fetch_array(MYSQLI_ASSOC);

         $_SESSION['user_name'] = $row['student_name'];
         $_SESSION['last_name'] = $row['lname'];
         $_SESSION['user_id'] = $row['student_id'];
         header('location:main.php');

      }
     else{
      $error = 'incorrect username or password!';
   }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>login</h3>
            <?php
      if(isset($error)){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      ?>
            <input type="text" name="username" required placeholder="enter your username">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name="submit" value="login now" class="form-btn">
        </form>

    </div>

</body>

</html>