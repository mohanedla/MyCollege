 
 <!-- <?php
$admin=1;
$name=$_POST['name'];
$id=$_POST['id'];
$password=$_POST['password'];
if(isset($_POST['Create'])){
    require_once 'dbconn.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) {
        echo "<p>Error: Could not connect to database.<br/>
        Please try again later.</p>";
          die($conn -> error);
      }
        $query ="INSERT INTO student (student_id, student_name,email, student_password,admin_id) VALUES
         ($id, '$name','$email', '$password',$admin)";

        $result = $conn->query($query);
        if ($result) {
            echo '<script language="javascript">
            alert("successfully registered");

            </script>';
        } else {
            echo   $conn -> error ;
            '<script language="javascript">
            alert("<br/>.The item was not added."+"<br/>+$query);

            </script>';
        }
           $conn -> close();

        include('home.php');
}
?> -->
<?php
$admin = 1;
require_once 'dbconn.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    echo "<p>Error: Could not connect to database.<br/>
    Please try again later.</p>";
      die($conn -> error);
  }
  
  if(isset($_POST['menu_ar_add'])){
   $full_name = $_POST['full_name_add'];
   $username = $_POST['username_add'];
   $password = $_POST['password_add'];

   $query ="INSERT INTO student (student_id, student_name, student_password,admin_id) VALUES
   ('$username', '$full_name', '$password',$admin)";

  $result = $conn->query($query);
  if ($result) {
      echo '<script language="javascript">
      alert("successfully registered");

      </script>';
  } else {
      echo   $conn -> error ;
      '<script language="javascript">
      alert("<br/>.The item was not added."+"<br/>+$query);

      </script>';
  }

 }
  include('home.php');
  ?>
   -->