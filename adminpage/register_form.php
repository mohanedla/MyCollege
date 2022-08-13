<?php
require_once '../dbconn/dbconn.php';

if(isset($_POST['submit'])){

   $username = $_POST['username'];
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];
   $select = "SELECT * FROM admin  WHERE  username='$username' ";
   $result = $conn->query($select);

   if($result->num_rows > 0){

      $error = 'user already exist!';

   }
   else{
      if($password != $cpassword){
         $error = 'password not matched!';
      }else{
         $insert = "INSERT INTO admin (username, admin_password)  VALUES 
         ('$username','$password')";
         $conn->query($insert);
         header('location:login_form.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>register</h3>
            <?php
      if(isset($error)){
            echo '<span class="error-msg">'.$error.'</span>';
      };
      ?>
            <input type="text" name="username" required placeholder="enter your username">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>already have an account? <a href="login_form.php">login now</a></p>
        </form>

    </div>

</body>

</html>