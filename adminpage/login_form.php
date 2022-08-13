<?php

require_once '../dbconn/dbconn.php';

session_start();

if(isset($_POST['submit'])){


   $username = $_POST['username'];
   $password = $_POST['password'];
   $select ="SELECT * FROM admin  WHERE   username='$username' and admin_password='$password'";

   $result = $conn->query($select);

   if($result->num_rows > 0){

      $row = $result->fetch_array(MYSQLI_ASSOC);
         $_SESSION['id'] = $row['id'];
         header('location:../student.php');
   }else{
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
      }
      ?>
            <input type="text" name="username" required placeholder="enter your username">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name="submit" value="login now" class="form-btn">
            <p>don't have an account? <a href="register_form.php">register now</a></p>
        </form>

    </div>

</body>

</html>